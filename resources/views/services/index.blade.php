@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Services</div>
        <h1>Our services</h1>
        <p>Websites, mobile apps and management systems — designed for real businesses, delivered with clear prices and real support.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="grid2">
            @foreach($services as $service)
                <a class="card" href="{{ route('services.show', $service->slug) }}">
                    <div class="ic" aria-hidden="true">{{ $service->icon }}</div>
                    <h3>{{ $service->title }} @if($service->title_bn)<span class="bn" lang="bn" style="display:inline;font-size:15px">· {{ $service->title_bn }}</span>@endif</h3>
                    <p>{{ $service->summary }}</p>
                    @if($service->features)
                        <ul class="check">@foreach(array_slice($service->features, 0, 4) as $f)<li>{{ $f }}</li>@endforeach</ul>
                    @endif
                    @if($service->price_note)<p style="margin-top:12px;font-weight:600;color:var(--blue)">{{ $service->price_note }}</p>@endif
                    <span class="more">View details →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
