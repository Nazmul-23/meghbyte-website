@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('insights.index') }}">Insights</a></div>
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->published_at->format('j F Y') }} · {{ $post->readingMinutes() }} min read</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <article class="prose">{!! $post->html() !!}</article>
    </div>
</section>

@if($related->isNotEmpty())
<section class="block alt">
    <div class="wrap">
        <h2>Keep reading</h2>
        <div class="grid2" style="margin-top:24px">
            @foreach($related as $r)
                <a class="card" href="{{ route('insights.show', $r->slug) }}"><span class="meta">{{ $r->published_at->format('j M Y') }}</span><h3 style="margin-top:8px">{{ $r->title }}</h3><p>{{ $r->excerpt }}</p></a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
