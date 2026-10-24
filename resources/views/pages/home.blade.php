@extends('layouts.app')

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    'name' => 'Meghbyte',
    'description' => 'Websites, mobile apps and management software for businesses.',
    'url' => url('/'),
    'telephone' => '+'.$wa,
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Hathazari', 'addressRegion' => 'Chattogram', 'addressCountry' => 'BD'],
    'areaServed' => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
<section class="hero">
    <div class="wrap hero-grid">
        <div>
            <h1>{{ $home['hero_title'] ?? 'Simple software that helps your business grow' }}</h1>
            @if(!empty($home['hero_bn']))<p class="bn" lang="bn">{{ $home['hero_bn'] }}</p>@endif
            <p class="lead">{{ $home['hero_subtitle'] ?? '' }}</p>
            <div class="cta-row">
                <a class="btn btn-o" href="{{ route('contact') }}">Get a free quote</a>
                <a class="btn btn-line" href="{{ route('work.index') }}">See our work</a>
            </div>
        </div>
        <div class="mock" aria-hidden="true">
            <div class="lap"><div class="bar" style="width:55%"></div><div class="cards"><div></div><div></div><div></div></div><div class="bar" style="width:80%;background:var(--orange);margin-top:18px"></div><div class="bar" style="width:40%;background:rgba(255,255,255,.3)"></div></div>
            <div class="ph"><div class="bar" style="width:70%"></div><div class="cards" style="flex-direction:column"><div style="height:50px"></div><div style="height:50px"></div></div><div class="bar" style="width:50%;background:var(--orange)"></div></div>
        </div>
    </div>
</section>

@if(!empty($home['trust_points']))
<div class="trust"><div class="wrap">
    @foreach($home['trust_points'] as $point)<span>{{ $point }}</span>@endforeach
</div></div>
@endif

<section class="block">
    <div class="wrap">
        <div class="head-row">
            <div><div class="eyebrow">What we build</div><h2>Services for every stage of your business</h2></div>
            <a class="btn btn-ghost btn-sm" href="{{ route('services.index') }}">All services</a>
        </div>
        <p class="sub">From a simple business website to a full management system — built with Laravel and Flutter and explained in plain words.</p>
        <div class="grid4">
            @foreach($services as $service)
                <a class="card" href="{{ route('services.show', $service->slug) }}">
                    <div class="ic" aria-hidden="true">{{ $service->icon }}</div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->summary }}</p>
                    @if($service->title_bn)<span class="bn" lang="bn">{{ $service->title_bn }}</span>@endif
                    <span class="more">Learn more →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if(!empty($home['why_us']))
<section class="block alt">
    <div class="wrap">
        <div class="eyebrow">Why Meghbyte</div>
        <h2>A software partner that thinks like a business owner</h2>
        <p class="sub">We are a small, focused team. You talk directly to the people who build your software.</p>
        <div class="grid4">
            @foreach($home['why_us'] as $why)
                <div class="card"><h3>{{ $why['title'] }}</h3><p>{{ $why['text'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($projects->isNotEmpty())
<section class="block">
    <div class="wrap">
        <div class="head-row">
            <div><div class="eyebrow">Our work</div><h2>We build the software we use ourselves</h2></div>
            <a class="btn btn-ghost btn-sm" href="{{ route('work.index') }}">All projects</a>
        </div>
        <p class="sub">Our first products run inside our own businesses before we offer them to clients.</p>
        <div class="grid3">
            @foreach($projects as $project)
                @include('partials.project-card', ['project' => $project])
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="block alt">
    <div class="wrap">
        <div class="eyebrow">How we work</div>
        <h2>Four clear steps, no surprises</h2>
        <p class="sub">You always know what you get, when you get it and what it costs.</p>
        <div class="grid4 steps">
            <div><div class="n">1</div><h3>Talk</h3><p>A free call or meeting to understand your business and what you need.</p></div>
            <div><div class="n">2</div><h3>Quote</h3><p>A written scope, fixed price and timeline. Work starts after the advance.</p></div>
            <div><div class="n">3</div><h3>Build</h3><p>Weekly updates and a demo link, so you see progress and give feedback early.</p></div>
            <div><div class="n">4</div><h3>Launch &amp; support</h3><p>We go live, train your team in Bangla or English and fix bugs free for 30 days.</p></div>
        </div>
    </div>
</section>

@if($packages->isNotEmpty())
<section class="block">
    <div class="wrap">
        <div class="head-row">
            <div><div class="eyebrow">Pricing</div><h2>Clear starting prices</h2></div>
            <a class="btn btn-ghost btn-sm" href="{{ route('pricing') }}">See all packages</a>
        </div>
        <p class="sub">Every project gets a written quotation based on your exact needs.</p>
        <div class="grid3">
            @foreach($packages as $package)
                @include('partials.price-card', ['package' => $package])
            @endforeach
        </div>
    </div>
</section>
@endif

@if($posts->isNotEmpty())
<section class="block alt">
    <div class="wrap">
        <div class="head-row">
            <div><div class="eyebrow">Insights</div><h2>Practical advice for business owners</h2></div>
            <a class="btn btn-ghost btn-sm" href="{{ route('insights.index') }}">All articles</a>
        </div>
        <div class="grid3" style="margin-top:28px">
            @foreach($posts as $post)
                <a class="card" href="{{ route('insights.show', $post->slug) }}">
                    <span class="meta">{{ $post->published_at->format('j M Y') }} · {{ $post->readingMinutes() }} min read</span>
                    <h3 style="margin-top:8px">{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                    <span class="more">Read article →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta', ['title' => $home['cta_title'] ?? null, 'text' => $home['cta_text'] ?? null])
@endsection
