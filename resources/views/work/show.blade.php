@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('work.index') }}">Work</a> / {{ $project->title }}</div>
        <div class="chips" style="justify-content:center;margin-top:18px"><span>{{ $project->categoryLabel() }}</span><span class="status-dot {{ $project->status === 'live' ? '' : 'dev' }}">{{ $project->statusLabel() }}</span></div>
        <h1>{{ $project->title }}</h1>
        <p class="lead">{{ $project->summary }}</p>
    </div>
</section>

<section class="sec" style="padding-top:60px">
    <div class="wrap split">
        <article class="prose">
            @if($project->problem)<h2 style="margin-top:0">The challenge</h2><p>{{ $project->problem }}</p>@endif
            @if($project->solution)<h2>What we built</h2><p>{{ $project->solution }}</p>@endif
            @if($project->features)
                <h2>Key features</h2>
                <ul class="checks">@foreach($project->features as $f)<li>{{ $f }}</li>@endforeach</ul>
            @endif
            @if($project->results)<h2>Where it stands</h2><p>{{ $project->results }}</p>@endif
        </article>
        <aside>
            <div class="card sticky">
                <h3>Project details</h3>
                @if($project->client_type)<p><strong style="color:#fff">Client:</strong> {{ $project->client_type }}</p>@endif
                <p><strong style="color:#fff">Status:</strong> {{ $project->statusLabel() }}</p>
                @if($project->tech_stack)
                    <p style="margin-top:16px"><strong style="color:#fff">Tech stack</strong></p>
                    <div class="chips">@foreach($project->tech_stack as $t)<span>{{ $t }}</span>@endforeach</div>
                @endif
                @if($project->url)<p style="margin-top:16px"><a href="{{ $project->url }}" target="_blank" rel="noopener nofollow" style="color:#C4B5FD">Visit project →</a></p>@endif
                <a class="btn btn-primary" style="margin-top:24px" href="{{ route('contact') }}">Build something similar <span class="arr">→</span></a>
            </div>
        </aside>
    </div>
</section>

@if($more->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <h2 class="title" style="font-size:36px">More projects</h2>
        <div class="cases">
            @foreach($more as $p)
                @include('partials.project-card', ['project' => $p])
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
