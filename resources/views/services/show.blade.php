@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('services.index') }}">Services</a> / {{ $service->title }}</div>
        <h1>{{ $service->icon }} {{ $service->title }}</h1>
        @if($service->title_bn)<p class="bn" lang="bn" style="color:#D1FAE5;margin-bottom:10px">{{ $service->title_bn }}</p>@endif
        <p>{{ $service->summary }}</p>
    </div>
</section>

<section class="block">
    <div class="wrap case">
        <div>
            <div class="prose">{!! $bodyHtml !!}</div>

            @if($service->features)
                <h2 style="margin-top:36px">What's included</h2>
                <ul class="check">@foreach($service->features as $f)<li>{{ $f }}</li>@endforeach</ul>
            @endif

            @if($service->ideal_for)
                <h2 style="margin-top:36px">Ideal for</h2>
                <div class="chips">@foreach($service->ideal_for as $f)<span>{{ $f }}</span>@endforeach</div>
            @endif

            @if($packages->isNotEmpty())
                <h2 style="margin-top:44px">Packages</h2>
                <div class="grid2" style="margin-top:20px">
                    @foreach($packages as $package)
                        @include('partials.price-card', ['package' => $package])
                    @endforeach
                </div>
            @endif
        </div>
        <aside>
            <div class="card">
                <h3>Start your project</h3>
                @if($service->price_note)<p style="font-weight:600;color:var(--blue)">{{ $service->price_note }}</p>@endif
                @if($service->tech)
                    <p style="margin-top:12px">Technology we use:</p>
                    <div class="chips">@foreach($service->tech as $t)<span>{{ $t }}</span>@endforeach</div>
                @endif
                <div style="display:grid;gap:10px;margin-top:20px">
                    <a class="btn btn-o" href="{{ route('contact', ['service' => $service->slug]) }}">Get a free quote</a>
                    <a class="btn btn-g" href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi Meghbyte, I am interested in '.$service->title) }}" target="_blank" rel="noopener">Ask on WhatsApp</a>
                </div>
            </div>
        </aside>
    </div>
</section>

@if($others->isNotEmpty())
<section class="block alt">
    <div class="wrap">
        <h2>Other services</h2>
        <div class="grid3" style="margin-top:24px">
            @foreach($others as $o)
                <a class="card" href="{{ route('services.show', $o->slug) }}"><div class="ic" aria-hidden="true">{{ $o->icon }}</div><h3>{{ $o->title }}</h3><p>{{ $o->summary }}</p></a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
