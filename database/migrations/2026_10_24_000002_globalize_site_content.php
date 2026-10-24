<?php

use App\Models\Faq;
use App\Models\Post;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Switches existing site content to the global, English-only version in
 * database/seeders/content.json (USD prices, no Bangla lines).
 * On a fresh database the tables are still empty here, so nothing happens
 * and the seeder loads the same file afterwards.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Service::withTrashed()->exists()) {
            return;
        }

        $content = json_decode(file_get_contents(database_path('seeders/content.json')), true, 512, JSON_THROW_ON_ERROR);

        Setting::put('home', $content['home']);
        Setting::put('about', $content['about']);
        Setting::put('seo', $content['seo']);
        Setting::put('privacy_policy', $content['privacy_policy_markdown']);

        foreach ($content['services'] as $s) {
            Service::withTrashed()->where('slug', $s['slug'])->update([
                'title' => $s['title'],
                'title_bn' => null,
                'icon' => $s['icon'] ?? null,
                'summary' => Str::limit($s['summary'], 295),
                'body' => $s['description'],
                'features' => json_encode($s['features'] ?? []),
                'tech' => json_encode($s['tech'] ?? []),
                'ideal_for' => json_encode($s['ideal_for'] ?? []),
                'price_note' => $s['starting_price_text'] ?? null,
            ]);
        }

        foreach ($content['projects'] as $p) {
            Project::withTrashed()->where('slug', $p['slug'])->update([
                'title' => $p['title'],
                'client_type' => $p['client_type'] ?? null,
                'summary' => Str::limit($p['summary'], 295),
                'problem' => $p['problem'] ?? null,
                'solution' => $p['solution'] ?? null,
                'results' => $p['result'] ?? null,
                'features' => json_encode($p['features'] ?? []),
                'tech_stack' => json_encode($p['tech'] ?? []),
            ]);
        }

        foreach ($content['posts'] as $p) {
            Post::withTrashed()->where('slug', $p['slug'])->update([
                'title' => $p['title'],
                'excerpt' => Str::limit($p['excerpt'], 295),
                'body' => $p['body_markdown'],
            ]);
        }

        // Old package slugs -> new content (the coaching package was renamed).
        $renamed = ['coaching-center-system' => 'School & Coaching System'];
        foreach ($content['packages'] as $pk) {
            $slug = Str::slug($pk['name']);
            $oldSlug = array_search($pk['name'], $renamed, true) ?: $slug;
            PricingPackage::withTrashed()->whereIn('slug', [$slug, $oldSlug])->update([
                'name' => $pk['name'],
                'slug' => $slug,
                'price' => (int) $pk['price'],
                'price_suffix' => $pk['price_suffix'] ?: null,
                'delivery' => $pk['delivery'] ?? null,
                'features' => json_encode($pk['features'] ?? []),
            ]);
        }

        Faq::query()->delete();
        foreach ($content['faq'] as $i => $f) {
            Faq::create(['question' => $f['q'], 'answer' => $f['a'], 'is_published' => true, 'sort_order' => $i]);
        }
    }

    public function down(): void
    {
        // Content change only; nothing to roll back structurally.
    }
};
