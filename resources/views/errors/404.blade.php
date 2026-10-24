@extends('layouts.app', ['seo' => ['title' => 'Page not found', 'description' => 'This page does not exist.', 'noindex' => true]])

@section('content')
<section class="block">
    <div class="wrap" style="max-width:720px;text-align:center">
        <div style="font-size:64px;font-weight:700;color:var(--blue)">404</div>
        <h1 style="color:var(--blue);margin-top:0">This page drifted away like a cloud</h1>
        <p class="sub" style="margin:0 auto 26px">The page you are looking for does not exist or has moved.</p>
        <div class="cta-row" style="justify-content:center">
            <a class="btn btn-b" href="{{ route('home') }}">Go home</a>
            <a class="btn btn-ghost" href="{{ route('services.index') }}">Our services</a>
            <a class="btn btn-o" href="{{ route('contact') }}">Contact us</a>
        </div>
    </div>
</section>
@endsection
