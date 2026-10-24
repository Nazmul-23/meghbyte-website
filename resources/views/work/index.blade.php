@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Work</div>
        <h1>Our <span class="serif grad-text">Work</span></h1>
        <p class="lead">Real products, built and used in real businesses. Each case study shows the problem, what we built and where it stands today.</p>
        <div class="chips" style="justify-content:center;margin-top:28px">
            <a href="{{ route('work.index') }}" @class(['on' => ! $category])>All</a>
            @foreach(\App\Models\Project::CATEGORIES as $key => $label)
                <a href="{{ route('work.index', ['category' => $key]) }}" @class(['on' => $category === $key])>{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="sec" style="padding-top:50px">
    <div class="wrap">
        @if($projects->isEmpty())
            <p class="lead center" style="margin:0 auto">No projects in this category yet.</p>
        @else
            <div class="cases" style="margin-top:0">
                @foreach($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
</section>

@include('partials.cta', ['title' => 'Want something like this?'])
@endsection
