@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Contact</div>
        <h1>Let's Build <span class="serif grad-text">Something Great</span></h1>
        <p class="lead">Tell us about your project. We reply within 24 hours with honest advice and a clear proposal.</p>
    </div>
</section>

<section class="sec" style="padding-top:50px">
    <div class="wrap contact">
        <div class="offer">
            <span class="eyebrow">Free consultation</span>
            <h2 style="margin-top:18px">What happens <span class="serif">next?</span></h2>
            <ul>
                <li>We read your brief and reply within 24 hours</li>
                <li>A free 30-minute discovery call</li>
                <li>A written proposal with scope, timeline and fixed price</li>
                <li>Happy to sign an NDA on request</li>
            </ul>
            <div class="wa">Prefer chat? <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp +{{ $wa }} →</a></div>
        </div>
        @include('partials.quote-form', ['services' => $services, 'budgets' => $budgets, 'selected' => $selected])
    </div>
</section>
@endsection
