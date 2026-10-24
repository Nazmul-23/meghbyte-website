@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Insights</div>
        <h1>Insights &amp; <span class="serif grad-text">Ideas</span></h1>
        <p class="lead">Practical advice on websites, apps and business software for founders and growing teams.</p>
    </div>
</section>

<section class="sec" style="padding-top:50px">
    <div class="wrap">
        @if($posts->isEmpty())
            <p class="lead center" style="margin:0 auto">Articles are coming soon.</p>
        @else
            <div class="cards3" style="margin-top:0">
                @foreach($posts as $post)
                    <a class="card" href="{{ route('insights.show', $post->slug) }}">
                        <span class="meta">{{ $post->published_at->format('M j, Y') }} · {{ $post->readingMinutes() }} min read</span>
                        <h3 style="margin-top:12px">{{ $post->title }}</h3>
                        <p>{{ $post->excerpt }}</p>
                        <span class="more">Read article →</span>
                    </a>
                @endforeach
            </div>
            {{ $posts->links() }}
        @endif
    </div>
</section>
@endsection
