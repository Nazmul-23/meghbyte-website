@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('services.index') }}">Services</a> / {{ $service->title }}</div>
        <h1>{{ $service->title }}</h1>
        <p class="lead">{{ $service->summary }}</p>
    </div>
</section>

<section class="sec" style="padding-top:60px">
    <div class="wrap split">
        <div>
            <div class="prose">{!! $bodyHtml !!}</div>

            @if($service->features)
                <h2 style="font-size:28px;margin-top:44px">What's included</h2>
                <ul class="checks">@foreach($service->features as $f)<li>{{ $f }}</li>@endforeach</ul>
            @endif

            @if($service->ideal_for)
                <h2 style="font-size:28px;margin-top:44px">Ideal for</h2>
                <div class="chips">@foreach($service->ideal_for as $f)<span>{{ $f }}</span>@endforeach</div>
            @endif
        </div>
        <aside>
            <div class="card sticky">
                <h3>Start your project</h3>
                @if($service->price_note)<p style="color:#6EE7B7;font-weight:600">{{ $service->price_note }}</p>@endif
                @if($service->tech)
                    <p style="margin-top:16px">Technology we use</p>
                    <div class="chips">@foreach($service->tech as $t)<span>{{ $t }}</span>@endforeach</div>
                @endif
                <div style="display:grid;gap:10px;margin-top:24px">
                    <a class="btn btn-primary" href="{{ route('contact', ['service' => $service->slug]) }}">Get a proposal <span class="arr">→</span></a>
                    <a class="btn btn-ghost" href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi Meghbyte, I am interested in '.$service->title) }}" target="_blank" rel="noopener">Ask on WhatsApp</a>
                </div>
            </div>
        </aside>
    </div>
</section>

@if($packages->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center"><span class="eyebrow">Packages</span><h2 class="title">Choose a <span class="serif grad-text">Starting Point</span></h2></div>
        <div class="price-grid">
            @foreach($packages as $package)
                @include('partials.price-card', ['package' => $package])
            @endforeach
        </div>
    </div>
</section>
@endif

@if($others->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <h2 class="title" style="font-size:36px">Other services</h2>
        <div class="cards3">
            @foreach($others as $o)
                <a class="card" href="{{ route('services.show', $o->slug) }}"><div class="svc" style="padding:0;border:0;background:none"><div class="ic" aria-hidden="true">{{ $o->icon }}</div></div><h3 style="margin-top:18px">{{ $o->title }}</h3><p>{{ $o->summary }}</p><span class="more">Learn more →</span></a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
