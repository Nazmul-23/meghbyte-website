@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Work</div>
        <h1>Our work</h1>
        <p>Real products, built and used in real businesses. Each case study shows the problem, what we built and where it stands today.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="chips" style="margin-bottom:28px">
            <a class="btn btn-sm {{ $category ? 'btn-ghost' : 'btn-b' }}" href="{{ route('work.index') }}">All</a>
            @foreach(\App\Models\Project::CATEGORIES as $key => $label)
                <a class="btn btn-sm {{ $category === $key ? 'btn-b' : 'btn-ghost' }}" href="{{ route('work.index', ['category' => $key]) }}">{{ $label }}</a>
            @endforeach
        </div>
        @if($projects->isEmpty())
            <p class="sub">No projects in this category yet.</p>
        @else
            <div class="grid3">
                @foreach($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
</section>

@include('partials.cta', ['title' => 'Want something like this for your business?'])
@endsection
