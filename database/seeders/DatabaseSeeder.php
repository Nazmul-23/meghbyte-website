<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Faq;
use App\Models\Post;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Idempotent: creates the first admin from ADMIN_EMAIL / ADMIN_PASSWORD and
     * loads the website content only when the tables are still empty.
     */
    public function run(): void
    {
        $this->seedAdmin();

        if (Service::withTrashed()->exists()) {
            $this->command?->info('Content already present — skipping content seed.');

            return;
        }

        $content = json_decode(file_get_contents(__DIR__.'/content.json'), true, 512, JSON_THROW_ON_ERROR);

        Setting::put('home', $content['home']);
        Setting::put('about', $content['about']);
        Setting::put('seo', $content['seo']);
        Setting::put('privacy_policy', $content['privacy_policy_markdown']);

        $serviceIds = [];
        foreach ($content['services'] as $i => $s) {
            $service = new Service([
                'title' => $s['title'],
                'title_bn' => $s['title_bn'] ?? null,
                'slug' => $s['slug'],
                'icon' => $s['icon'] ?? null,
                'summary' => Str::limit($s['summary'], 295),
                'body' => is_array($s['description']) ? implode("\n\n", $s['description']) : $s['description'],
                'features' => $s['features'] ?? [],
                'tech' => $s['tech'] ?? [],
                'ideal_for' => $s['ideal_for'] ?? [],
                'price_note' => $s['starting_price_text'] ?? null,
                'sort_order' => $i,
            ]);
            $service->is_featured = true;
            $service->is_published = true;
            $service->save();
            $serviceIds[$s['slug']] = $service->id;
        }

        $categories = ['ss-helper' => 'app', 'coaching-center-management-system' => 'system'];
        foreach ($content['projects'] as $i => $p) {
            $project = new Project([
                'title' => $p['title'],
                'slug' => $p['slug'],
                'client_type' => $p['client_type'] ?? null,
                'category' => $categories[$p['slug']] ?? 'web',
                'status' => strtolower($p['status']) === 'live' ? 'live' : 'in_development',
                'summary' => Str::limit($p['summary'], 295),
                'problem' => $p['problem'] ?? null,
                'solution' => $p['solution'] ?? null,
                'results' => $p['result'] ?? null,
                'features' => $p['features'] ?? [],
                'tech_stack' => $p['tech'] ?? [],
                'sort_order' => $i,
            ]);
            $project->is_featured = true;
            $project->is_published = true;
            $project->save();
        }

        $groups = [
            'Starter Business Website' => ['websites', 'websites-ecommerce'],
            'Website + Admin Panel' => ['websites', 'websites-ecommerce'],
            'E-commerce Store' => ['websites', 'websites-ecommerce'],
            'Business Mobile App' => ['apps', 'mobile-apps'],
            'School & Coaching System' => ['systems', 'management-systems'],
            'Inventory & Billing' => ['systems', 'management-systems'],
            'Care & Maintenance' => ['care', 'care-maintenance'],
        ];
        foreach ($content['packages'] as $i => $pk) {
            [$group, $serviceSlug] = $groups[$pk['name']] ?? ['websites', null];
            PricingPackage::create([
                'name' => $pk['name'],
                'slug' => Str::slug($pk['name']),
                'group' => $group,
                'price' => (int) ($pk['price'] ?? $pk['price_bdt'] ?? 0),
                'price_suffix' => $pk['price_suffix'] ?: null,
                'delivery' => $pk['delivery'] ?? null,
                'features' => $pk['features'] ?? [],
                'is_highlighted' => (bool) ($pk['highlighted'] ?? false),
                'is_published' => true,
                'sort_order' => $pk['sort_order'] ?? $i,
                'service_id' => $serviceSlug ? ($serviceIds[$serviceSlug] ?? null) : null,
            ]);
        }

        $authorId = User::query()->orderBy('id')->value('id');
        foreach ($content['posts'] as $i => $p) {
            $post = new Post([
                'title' => $p['title'],
                'slug' => $p['slug'],
                'excerpt' => Str::limit($p['excerpt'], 295),
                'body' => $p['body_markdown'],
                'status' => 'published',
                'published_at' => now()->subDays(3 - $i),
            ]);
            $post->author_id = $authorId;
            $post->save();
        }

        foreach ($content['faq'] as $i => $f) {
            Faq::create(['question' => $f['q'], 'answer' => $f['a'], 'is_published' => true, 'sort_order' => $i]);
        }
    }

    private function seedAdmin(): void
    {
        $email = getenv('ADMIN_EMAIL') ?: null;
        $password = getenv('ADMIN_PASSWORD') ?: null;

        if (! $email || ! $password || User::query()->exists()) {
            return;
        }

        $user = new User(['name' => 'Meghbyte Admin', 'email' => $email, 'password' => $password]);
        $user->role = Role::Admin;
        $user->is_active = true;
        $user->save();

        $this->command?->info("Admin user created: {$email}");
    }
}
