@extends('layouts.app')

@section('content')
<section class="block">
    <div class="wrap" style="max-width:720px;text-align:center">
        <div class="ic" style="margin:0 auto 18px;width:72px;height:72px;font-size:36px">✅</div>
        <h1 style="color:var(--blue)">Thank you{{ session('lead_name') ? ', '.session('lead_name') : '' }}!</h1>
        <p class="sub" style="margin:0 auto 26px">We received your request and will reply soon — usually the same day. For a faster answer, send us a message on WhatsApp.</p>
        <p class="bn" lang="bn">আপনার অনুরোধ পেয়েছি, খুব শীঘ্রই যোগাযোগ করব।</p>
        <div class="cta-row" style="justify-content:center;margin-top:22px">
            <a class="btn btn-g" href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi Meghbyte, I just sent a quote request on your website.') }}" target="_blank" rel="noopener">Message us on WhatsApp</a>
            <a class="btn btn-ghost" href="{{ route('work.index') }}">See our work</a>
        </div>
    </div>
</section>
@endsection
