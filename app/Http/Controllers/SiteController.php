<?php

namespace App\Http\Controllers;

use App\Enums\LeadStatus;
use App\Http\Requests\StoreQuoteRequest;
use App\Models\Faq;
use App\Models\Post;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Support\Markdown;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'seo' => $this->seo('home'),
            'home' => Setting::get('home', []),
            'services' => Service::published()->get(),
            'projects' => Project::published()->take(3)->get(),
            'packages' => PricingPackage::published()->take(3)->get(),
            'posts' => Post::published()->take(3)->get(),
        ]);
    }

    public function services(): View
    {
        return view('services.index', [
            'seo' => $this->seo('services'),
            'services' => Service::published()->get(),
        ]);
    }

    public function service(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('services.show', [
            'seo' => [
                'title' => $service->meta_title ?: $service->title,
                'description' => $service->meta_description ?: Str::limit($service->summary, 155),
            ],
            'service' => $service,
            'bodyHtml' => Markdown::toSafeHtml($service->body),
            'packages' => PricingPackage::published()->where('service_id', $service->id)->get(),
            'others' => Service::published()->where('id', '!=', $service->id)->get(),
        ]);
    }

    public function work(Request $request): View
    {
        $category = $request->query('category');
        $category = is_string($category) && array_key_exists($category, Project::CATEGORIES) ? $category : null;

        return view('work.index', [
            'seo' => $this->seo('work'),
            'projects' => Project::published()->when($category, fn ($q) => $q->where('category', $category))->get(),
            'category' => $category,
        ]);
    }

    public function project(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('work.show', [
            'seo' => [
                'title' => $project->meta_title ?: $project->title.' — Case study',
                'description' => $project->meta_description ?: Str::limit($project->summary, 155),
            ],
            'project' => $project,
            'more' => Project::published()->where('id', '!=', $project->id)->take(2)->get(),
        ]);
    }

    public function pricing(): View
    {
        return view('pages.pricing', [
            'seo' => $this->seo('pricing'),
            'packages' => PricingPackage::published()->get(),
            'faqs' => Faq::published()->get(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'seo' => $this->seo('about'),
            'about' => Setting::get('about', []),
        ]);
    }

    public function insights(): View
    {
        return view('insights.index', [
            'seo' => $this->seo('insights'),
            'posts' => Post::published()->paginate(9),
        ]);
    }

    public function post(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('insights.show', [
            'seo' => [
                'title' => $post->meta_title ?: $post->title,
                'description' => $post->meta_description ?: Str::limit($post->excerpt, 155),
                'type' => 'article',
            ],
            'post' => $post,
            'related' => Post::published()->where('id', '!=', $post->id)->take(2)->get(),
        ]);
    }

    public function contact(Request $request): View
    {
        $slug = $request->query('service');
        $selected = is_string($slug) ? Service::where('slug', $slug)->value('id') : null;

        return view('pages.contact', [
            'seo' => $this->seo('contact'),
            'services' => Service::published()->get(['id', 'title']),
            'budgets' => QuoteRequest::BUDGETS,
            'selected' => old('service_id', $selected),
        ]);
    }

    public function storeQuote(StoreQuoteRequest $request): RedirectResponse
    {
        // Honeypot: bots fill the hidden "website" field. Pretend success, store nothing.
        if ($request->filled('website')) {
            return redirect()->route('contact.thanks');
        }

        $lead = new QuoteRequest($request->safe()->except(['phone']));
        $lead->phone = $request->normalizedPhone();
        $lead->status = LeadStatus::New;
        $lead->source_page = Str::limit((string) $request->headers->get('referer'), 250, '');
        $lead->ip_address = $request->ip();
        $lead->user_agent = Str::limit((string) $request->userAgent(), 250, '');
        $lead->save();

        return redirect()->route('contact.thanks')->with('lead_name', $lead->name);
    }

    public function thanks(): View
    {
        return view('pages.thanks', ['seo' => ['title' => 'Thank you', 'description' => 'We received your request.', 'noindex' => true]]);
    }

    public function privacy(): View
    {
        return view('pages.privacy', [
            'seo' => ['title' => 'Privacy policy', 'description' => 'How Meghbyte handles the information you send us.'],
            'html' => Markdown::toSafeHtml((string) Setting::get('privacy_policy', '')),
        ]);
    }

    public function sitemap(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = collect([
                ['loc' => route('home'), 'lastmod' => null],
                ['loc' => route('services.index'), 'lastmod' => null],
                ['loc' => route('work.index'), 'lastmod' => null],
                ['loc' => route('pricing'), 'lastmod' => null],
                ['loc' => route('about'), 'lastmod' => null],
                ['loc' => route('insights.index'), 'lastmod' => null],
                ['loc' => route('contact'), 'lastmod' => null],
                ['loc' => route('privacy'), 'lastmod' => null],
            ]);

            foreach (Service::published()->get() as $s) {
                $urls->push(['loc' => route('services.show', $s->slug), 'lastmod' => $s->updated_at]);
            }
            foreach (Project::published()->get() as $p) {
                $urls->push(['loc' => route('work.show', $p->slug), 'lastmod' => $p->updated_at]);
            }
            foreach (Post::published()->get() as $p) {
                $urls->push(['loc' => route('insights.show', $p->slug), 'lastmod' => $p->updated_at]);
            }

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $lines = app()->isProduction()
            ? ['User-agent: *', 'Allow: /', 'Disallow: /admin', 'Sitemap: '.route('sitemap')]
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain']);
    }

    /** @return array{title: string, description: string} */
    private function seo(string $page): array
    {
        $all = Setting::get('seo', []);

        return [
            'title' => $all[$page]['title'] ?? 'Meghbyte',
            'description' => $all[$page]['description'] ?? 'Websites, mobile apps and management software from Hathazari, Chattogram.',
        ];
    }
}
