<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_public_pages_load(): void
    {
        foreach (['/', '/services', '/work', '/pricing', '/about', '/insights', '/contact', '/privacy', '/sitemap.xml', '/robots.txt'] as $url) {
            $this->get($url)->assertOk();
        }

        $service = Service::first();
        $this->get('/services/'.$service->slug)->assertOk()->assertSee($service->title);
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get('/services/does-not-exist')->assertNotFound();
        $this->get('/insights/does-not-exist')->assertNotFound();
    }

    public function test_security_headers_are_present(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    public function test_quote_form_stores_lead_with_normalised_phone(): void
    {
        $this->post('/contact', [
            'name' => 'Rahim',
            'phone' => '01812-345678',
            'message' => 'I need a website for my shop.',
        ])->assertRedirect(route('contact.thanks'));

        $lead = QuoteRequest::first();
        $this->assertSame('+8801812345678', $lead->phone);
        $this->assertSame('new', $lead->status->value);
    }

    public function test_honeypot_submission_is_not_stored(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'phone' => '01812345678',
            'message' => 'Spam spam spam spam',
            'website' => 'http://spam.test',
        ])->assertRedirect(route('contact.thanks'));

        $this->assertSame(0, QuoteRequest::count());
    }

    public function test_invalid_quote_shows_errors(): void
    {
        $this->post('/contact', ['name' => '', 'phone' => '123', 'message' => 'short'])
            ->assertSessionHasErrors(['name', 'phone', 'message']);
    }

    public function test_markdown_html_is_escaped(): void
    {
        $post = Post::first();
        $post->body = "Hello <script>alert(1)</script>";
        $post->save();

        $this->get('/insights/'.$post->slug)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/leads')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_log_in_and_see_dashboard(): void
    {
        $this->post('/admin/login', ['email' => 'admin@example.test', 'password' => 'test-password-123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/admin')->assertOk();
        $this->get('/admin/services')->assertOk();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        $user = User::first();
        $user->is_active = false;
        $user->save();

        $this->post('/admin/login', ['email' => 'admin@example.test', 'password' => 'test-password-123'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
