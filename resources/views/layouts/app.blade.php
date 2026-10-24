@php
    $pageTitle = isset($seo['title']) && $seo['title'] !== 'Meghbyte'
        ? (str_contains($seo['title'], 'Meghbyte') ? $seo['title'] : \Illuminate\Support\Str::limit($seo['title'], 55, '').' | Meghbyte')
        : 'Meghbyte — Websites, Mobile Apps & Management Software';
    $pageDesc = $seo['description'] ?? 'Websites, mobile apps and management software from Hathazari, Chattogram.';
    $nav = [
        'services.index' => 'Services',
        'work.index' => 'Work',
        'pricing' => 'Pricing',
        'about' => 'About',
        'insights.index' => 'Insights',
    ];
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @if(!empty($seo['noindex']))<meta name="robots" content="noindex">@endif
    <meta property="og:site_name" content="Meghbyte">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:image" content="{{ asset('og.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#1E3A8A">
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1">
    @stack('head')
</head>
<body>
<a class="skip" href="#main">Skip to content</a>
<header class="site-header">
    <div class="wrap nav">
        <a href="{{ route('home') }}" class="brand" aria-label="Meghbyte home">
            <span class="bi"><img src="{{ asset('icon.svg') }}" alt="" width="32" height="32"></span>
            <span class="bw">megh<span>byte</span></span>
        </a>
        <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false">☰</button>
        <nav class="menu" aria-label="Main">
            @foreach($nav as $route => $label)
                <a href="{{ route($route) }}" @class(['active' => request()->routeIs(str_replace('.index', '', $route).'*')])>{{ $label }}</a>
            @endforeach
            <a class="btn btn-o" href="{{ route('contact') }}">Get a free quote</a>
        </nav>
    </div>
</header>

<main id="main">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap">
        <div class="foot-grid">
            <div>
                <div class="brand" style="margin-bottom:12px"><span class="bi"><img src="{{ asset('icon.svg') }}" alt="" width="32" height="32"></span><span class="bw">megh<span>byte</span></span></div>
                <p style="margin:0 0 8px">Websites, mobile apps and management software for growing businesses.</p>
                <p class="bn" lang="bn" style="margin:0">আপনার ব্যবসার জন্য সহজ সফটওয়্যার।</p>
            </div>
            <div>
                <h4>Services</h4>
                @foreach(\App\Models\Service::published()->get(['title','slug']) as $s)
                    <a href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a>
                @endforeach
            </div>
            <div>
                <h4>Company</h4>
                <a href="{{ route('work.index') }}">Our work</a>
                <a href="{{ route('pricing') }}">Pricing</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('insights.index') }}">Insights</a>
                <a href="{{ route('privacy') }}">Privacy policy</a>
            </div>
            <div>
                <h4>Contact</h4>
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp: +{{ $wa }}</a>
                <a href="{{ route('contact') }}">Get a free quote</a>
                <span style="display:block;padding:3px 0">Hathazari, Chattogram, Bangladesh</span>
                <span style="display:block;padding:3px 0">Working with clients worldwide</span>
            </div>
        </div>
        <div class="foot-bottom">
            <span>© <span id="year">{{ date('Y') }}</span> Meghbyte. All rights reserved.</span>
            <span>Simple. Honest. Built to last.</span>
        </div>
    </div>
</footer>

<a class="btn btn-g wa-float" href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi Meghbyte, I want to discuss a project') }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">💬 WhatsApp</a>
<script src="{{ asset('js/app.js') }}?v=1" defer></script>
@stack('scripts')
</body>
</html>
