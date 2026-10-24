@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('work.index') }}">Work</a> / {{ $project->title }}</div>
        <div><span @class(['tag', 'live' => $project->status === 'live', 'dev' => $project->status !== 'live'])>{{ $project->statusLabel() }}</span> <span class="tag">{{ $project->categoryLabel() }}</span></div>
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->summary }}</p>
    </div>
</section>

<section class="block">
    <div class="wrap case">
        <article>
            @if($project->problem)<h2>The problem</h2><p>{{ $project->problem }}</p>@endif
            @if($project->solution)<h2 style="margin-top:32px">What we built</h2><p>{{ $project->solution }}</p>@endif
            @if($project->features)
                <h2 style="margin-top:32px">Key features</h2>
                <ul class="check">@foreach($project->features as $f)<li>{{ $f }}</li>@endforeach</ul>
            @endif
            @if($project->results)<h2 style="margin-top:32px">Where it stands</h2><p>{{ $project->results }}</p>@endif
        </article>
        <aside>
            <div class="card">
                <h3>Project details</h3>
                @if($project->client_type)<p><strong>Client:</strong> {{ $project->client_type }}</p>@endif
                <p><strong>Status:</strong> {{ $project->statusLabel() }}</p>
                @if($project->tech_stack)
                    <p style="margin-top:12px"><strong>Tech stack</strong></p>
                    <div class="chips">@foreach($project->tech_stack as $t)<span>{{ $t }}</span>@endforeach</div>
                @endif
                @if($project->url)<p style="margin-top:14px"><a href="{{ $project->url }}" target="_blank" rel="noopener nofollow">Visit project →</a></p>@endif
                <a class="btn btn-o" style="margin-top:20px" href="{{ route('contact') }}">Build something similar</a>
            </div>
        </aside>
    </div>
</section>

@if($more->isNotEmpty())
<section class="block alt">
    <div class="wrap">
        <h2>More projects</h2>
        <div class="grid2" style="margin-top:24px">
            @foreach($more as $p)
                @include('partials.project-card', ['project' => $p])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
