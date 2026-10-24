@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Privacy policy</div>
        <h1>Privacy policy</h1>
    </div>
</section>
<section class="block">
    <div class="wrap"><div class="prose">{!! $html !!}</div></div>
</section>
@endsection
