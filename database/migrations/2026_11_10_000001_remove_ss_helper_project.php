<?php

use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /** Remove the SS Helper case study from the public site and drop references to it. */
    public function up(): void
    {
        Project::query()->where('slug', 'ss-helper')->get()->each->delete();

        $seo = Setting::get('seo');
        if (is_array($seo) && isset($seo['work']['description'])) {
            $seo['work']['description'] = 'Meghbyte projects: a school and coaching management system and a Laravel e-commerce store, with real screens from each.';
            Setting::put('seo', $seo);
        }

        $service = Service::query()->where('slug', 'mobile-apps')->first();
        if ($service && str_contains((string) $service->body, 'SS Helper')) {
            $paras = array_filter(
                preg_split("/\n\s*\n/", (string) $service->body),
                fn ($p) => ! str_contains($p, 'SS Helper')
            );
            $service->body = implode("\n\n", $paras);
            $service->save();
        }
    }

    public function down(): void
    {
        Project::withTrashed()->where('slug', 'ss-helper')->get()->each->restore();
    }
};
