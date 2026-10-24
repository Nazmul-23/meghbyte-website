@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Services</div>
        <h1>Services That <span class="serif grad-text">Move You Forward</span></h1>
        <p class="lead">Websites, mobile apps and custom systems, designed for real businesses and delivered with clear prices and real support.</p>
    </div>
</section>

<section class="sec" style="padding-top:60px">
    <div class="wrap">
        <div class="svc-grid" style="margin-top:0">
            @foreach($services as $service)
                <a class="svc" href="{{ route('services.show', $service->slug) }}">
                    <div class="ic" aria-hidden="true">{{ $service->icon }}</div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->summary }}</p>
                    @if($service->features)
                        <ul>@foreach(array_slice($service->features, 0, 5) as $f)<li>{{ $f }}</li>@endforeach</ul>
                    @endif
                    @if($service->price_note)<div class="price">{{ $service->price_note }}</div>@endif
                    <span class="more">View details →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
