@php
    $pageTitle = isset($seo['title']) && $seo['title'] !== 'Meghbyte'
        ? (str_contains($seo['title'], 'Meghbyte') ? $seo['title'] : \Illuminate\Support\Str::limit($seo['title'], 55, '').' | Meghbyte')
        : 'Meghbyte | Web, App & Custom Software Development Studio';
    $pageDesc = $seo['description'] ?? 'Meghbyte designs and builds websites, mobile apps and custom software for founders and growing businesses worldwide.';
    $nav = ['work.index' => 'Work', 'services.index' => 'Services', 'pricing' => 'Pricing', 'about' => 'About'];
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
    <meta name="theme-color" content="#09060F">
    <link rel="icon" href="{{ asset('icon.svg') }}?v=3" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=3">
    @stack('head')
</head>
<body>
<a class="skip" href="#main">Skip to content</a>

<header class="topbar">
    <div class="wrap">
        <a href="{{ route('home') }}" class="brand" aria-label="Meghbyte home"><img src="{{ asset('icon.svg') }}?v=3" alt="" width="34" height="34"><b class="wm">megh<span>byte</span></b></a>
        <a class="contact-link" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">Chat on WhatsApp ↗</a>
    </div>
</header>

<nav class="pillnav" aria-label="Main">
    @foreach($nav as $route => $label)
        <a href="{{ route($route) }}" @class(['active' => request()->routeIs(str_replace('.index', '', $route).'*'), 'hide-sm' => $route === 'about'])>{{ $label }}</a>
    @endforeach
    <a class="cta" href="{{ route('contact') }}">Let's Talk →</a>
</nav>

<main id="main">
    @yield('content')
</main>

<footer class="footer">
    <div class="wrap">
        <div class="fgrid">
            <div>
                <a href="{{ route('home') }}" class="brand"><img src="{{ asset('icon.svg') }}?v=3" alt="" width="34" height="34"><b class="wm">megh<span>byte</span></b></a>
                <p class="tag">A founder-led software studio. We design and build websites, apps and custom systems for growing businesses worldwide.</p>
            </div>
            <div>
                <h4>Services</h4>
                @foreach(\App\Models\Service::published()->get(['title','slug']) as $s)
                    <a href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a>
                @endforeach
            </div>
            <div>
                <h4>Company</h4>
                <a href="{{ route('work.index') }}">Case studies</a>
                <a href="{{ route('pricing') }}">Pricing</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('insights.index') }}">Insights</a>
            </div>
            <div>
                <h4>Contact</h4>
                <a href="{{ route('contact') }}">Book a free consultation</a>
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp: +{{ $wa }}</a>
                <span>Working with clients worldwide</span>
            </div>
        </div>
        <div class="bigword" aria-hidden="true">meghbyte</div>
        <div class="bottom">
            <span>© {{ date('Y') }} Meghbyte. All rights reserved.</span>
            <a href="{{ route('privacy') }}">Privacy policy</a>
        </div>
    </div>
</footer>
<script src="{{ asset('js/app.js') }}?v=2" defer></script>
@stack('scripts')
</body>
</html>
