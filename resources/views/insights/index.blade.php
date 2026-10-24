@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Insights</div>
        <h1>Insights</h1>
        <p>Practical advice on websites, apps and software for business owners in Bangladesh and beyond.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        @if($posts->isEmpty())
            <p class="sub">Articles are coming soon.</p>
        @else
            <div class="grid3">
                @foreach($posts as $post)
                    <a class="card" href="{{ route('insights.show', $post->slug) }}">
                        <span class="meta">{{ $post->published_at->format('j M Y') }} · {{ $post->readingMinutes() }} min read</span>
                        <h3 style="margin-top:8px">{{ $post->title }}</h3>
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
