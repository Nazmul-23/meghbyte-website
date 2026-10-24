@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap" style="max-width:900px">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('insights.index') }}">Insights</a></div>
        <h1 style="font-size:clamp(34px,5vw,56px)">{{ $post->title }}</h1>
        <p class="lead">{{ $post->published_at->format('F j, Y') }} · {{ $post->readingMinutes() }} min read</p>
    </div>
</section>

<section class="sec" style="padding-top:50px">
    <div class="wrap" style="max-width:780px">
        <article class="prose">{!! $post->html() !!}</article>
    </div>
</section>

@if($related->isNotEmpty())
<section class="sec" style="padding-top:10px">
    <div class="wrap">
        <h2 class="title" style="font-size:34px">Keep reading</h2>
        <div class="cards3">
            @foreach($related as $r)
                <a class="card" href="{{ route('insights.show', $r->slug) }}"><span class="meta">{{ $r->published_at->format('M j, Y') }}</span><h3 style="margin-top:12px">{{ $r->title }}</h3><p>{{ $r->excerpt }}</p></a>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
