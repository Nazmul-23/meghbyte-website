@extends('layouts.app')

@section('content')
<section class="phead" style="padding-bottom:110px">
    <div class="wrap">
        <span class="eyebrow">Inquiry received</span>
        <h1>Thank you{{ session('lead_name') ? ', '.session('lead_name') : '' }}<span class="serif grad-text">!</span></h1>
        <p class="lead">We received your request and will reply within 24 hours. For a faster answer, send us a message on WhatsApp.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:30px">
            <a class="btn btn-primary" href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi Meghbyte, I just sent an inquiry on your website.') }}" target="_blank" rel="noopener">Message us on WhatsApp</a>
            <a class="btn btn-ghost" href="{{ route('work.index') }}">See our work</a>
        </div>
    </div>
</section>
@endsection
