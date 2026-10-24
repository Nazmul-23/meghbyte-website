@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / About</div>
        <h1>Small Team, <span class="serif grad-text">Big Care</span></h1>
        @if(!empty($about['mission']))<p class="lead">{{ $about['mission'] }}</p>@endif
    </div>
</section>

<section class="sec" style="padding-top:60px">
    <div class="wrap split">
        <div class="prose">
            @foreach((array) ($about['story'] ?? []) as $para)
                <p>{{ $para }}</p>
            @endforeach
        </div>
        <aside>
            <div class="offer sticky">
                <img src="{{ asset('icon.svg') }}" alt="" width="64" height="64" style="border-radius:18px">
                <h2 style="margin-top:20px;font-size:32px">Simple. Honest. <span class="serif">Built to last.</span></h2>
                <p style="color:#DDD6FE;margin-top:12px">Founder-led studio working with clients worldwide.</p>
            </div>
        </aside>
    </div>
</section>

@if(!empty($about['values']))
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center"><span class="eyebrow">Our values</span><h2 class="title">What You Can <span class="serif grad-text">Expect</span></h2></div>
        <div class="cards3">
            @foreach($about['values'] as $value)
                <div class="card"><h3>{{ $value['title'] }}</h3><p>{{ $value['text'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="sec" style="padding-top:20px">
    <div class="wrap center">
        <span class="eyebrow">Technology</span>
        <h2 class="title">Proven Tools, <span class="serif grad-text">Used Carefully</span></h2>
        <div class="chips" style="justify-content:center;margin-top:26px">
            @foreach(['Laravel', 'PHP', 'Flutter', 'Dart', 'PostgreSQL', 'MySQL', 'Livewire', 'Tailwind CSS', 'Firebase', 'Docker', 'GitHub', 'Figma'] as $t)<span>{{ $t }}</span>@endforeach
        </div>
    </div>
</section>

@include('partials.cta')
@endsection
