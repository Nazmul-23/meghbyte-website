@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Privacy</div>
        <h1>Privacy <span class="serif grad-text">Policy</span></h1>
    </div>
</section>
<section class="sec" style="padding-top:50px">
    <div class="wrap" style="max-width:820px"><div class="prose">{!! $html !!}</div></div>
</section>
@endsection
