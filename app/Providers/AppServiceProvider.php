<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        // Catch lazy loading and silently discarded attributes while developing.
        Model::shouldBeStrict(! $this->app->isProduction());

        Paginator::defaultView('partials.pagination');

        View::share('wa', preg_replace('/\D/', '', (string) (getenv('WHATSAPP_NUMBER') ?: '8801890827598')));

        RateLimiter::for('quote', function (Request $request) {
            $back = fn () => redirect()->route('contact')->withInput()->with('error', 'Too many requests. Please wait a few minutes or message us on WhatsApp.');

            return [
                Limit::perMinutes(10, 3)->by('quote10:'.$request->ip())->response($back),
                Limit::perDay(10)->by('quoteday:'.$request->ip())->response($back),
            ];
        });

        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()),
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            ];
        });
    }
}
