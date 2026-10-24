@extends('layouts.app', ['seo' => ['title' => 'Page not found', 'description' => 'This page does not exist.', 'noindex' => true]])

@section('content')
<section class="phead" style="padding-bottom:110px">
    <div class="wrap">
        <span class="eyebrow">Error 404</span>
        <h1>This page drifted <span class="serif grad-text">away</span></h1>
        <p class="lead">The page you are looking for does not exist or has moved.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:30px">
            <a class="btn btn-primary" href="{{ route('home') }}">Go home</a>
            <a class="btn btn-ghost" href="{{ route('services.index') }}">Our services</a>
            <a class="btn btn-ghost" href="{{ route('contact') }}">Contact us</a>
        </div>
    </div>
</section>
@endsection
