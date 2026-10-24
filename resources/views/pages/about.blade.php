@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / About</div>
        <h1>{{ $about['title'] ?? 'About Meghbyte' }}</h1>
        @if(!empty($about['mission']))<p>{{ $about['mission'] }}</p>@endif
    </div>
</section>

<section class="block">
    <div class="wrap case">
        <div class="prose">
            @foreach((array) ($about['story'] ?? []) as $para)
                <p>{{ $para }}</p>
            @endforeach
        </div>
        <aside>
            <div class="card" style="background:linear-gradient(135deg,var(--blue),var(--blue2));color:#fff;border:0">
                <div class="bi" style="width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center"><img src="{{ asset('icon.svg') }}" alt="" width="52" height="52"></div>
                <p style="color:#fff;font-size:20px;font-weight:600;margin-top:16px">Simple. Honest. Built to last.</p>
                <p class="bn" lang="bn" style="color:#D1FAE5">সহজ, সৎ, টেকসই সফটওয়্যার।</p>
                <p style="color:#E0E7FF;margin-top:10px">Hathazari, Chattogram · Working worldwide</p>
            </div>
        </aside>
    </div>
</section>

@if(!empty($about['values']))
<section class="block alt">
    <div class="wrap">
        <div class="eyebrow">Our values</div>
        <h2>What you can expect from us</h2>
        <div class="grid3" style="margin-top:28px">
            @foreach($about['values'] as $value)
                <div class="card"><h3>{{ $value['title'] }}</h3><p>{{ $value['text'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="block">
    <div class="wrap">
        <div class="eyebrow">Technology</div>
        <h2>Proven tools, used carefully</h2>
        <p class="sub">We build on mature, well-supported technology so your software stays maintainable for years.</p>
        <div class="chips">
            @foreach(['Laravel', 'PHP', 'Flutter', 'Dart', 'MySQL', 'PostgreSQL', 'Tailwind CSS', 'Firebase', 'bKash / SSLCommerz', 'Git & GitHub'] as $t)<span>{{ $t }}</span>@endforeach
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
