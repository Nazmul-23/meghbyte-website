<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Public website
Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/services', 'services')->name('services.index');
    Route::get('/services/{slug}', 'service')->name('services.show');
    Route::get('/work', 'work')->name('work.index');
    Route::get('/work/{slug}', 'project')->name('work.show');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/about', 'about')->name('about');
    Route::get('/insights', 'insights')->name('insights.index');
    Route::get('/insights/{slug}', 'post')->name('insights.show');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'storeQuote')->middleware('throttle:quote')->name('quote.store');
    Route::get('/contact/thanks', 'thanks')->name('contact.thanks');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap');
    Route::get('/robots.txt', 'robots')->name('robots');
});

// Admin area (no public registration)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'show'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/account', [AccountController::class, 'edit'])->name('account');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');

        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
        Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

        Route::pattern('resource', 'services|projects|packages|posts|faqs');
        Route::get('/{resource}', [ResourceController::class, 'index'])->name('resource.index');
        Route::get('/{resource}/create', [ResourceController::class, 'create'])->name('resource.create');
        Route::post('/{resource}', [ResourceController::class, 'store'])->name('resource.store');
        Route::get('/{resource}/{id}/edit', [ResourceController::class, 'edit'])->whereNumber('id')->name('resource.edit');
        Route::put('/{resource}/{id}', [ResourceController::class, 'update'])->whereNumber('id')->name('resource.update');
        Route::delete('/{resource}/{id}', [ResourceController::class, 'destroy'])->whereNumber('id')->name('resource.destroy');
    });
});
