@extends('layouts.app')

@section('content')
<section class="phead">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Pricing</div>
        <h1>Simple Packages, <span class="serif grad-text">Honest Prices</span></h1>
        <p class="lead">Starting prices in USD. You always get a written proposal for your exact scope before any work starts.</p>
    </div>
</section>

<section class="sec" style="padding-top:20px">
    <div class="wrap">
        @foreach(\App\Models\PricingPackage::GROUPS as $group => $label)
            @php $items = $packages->where('group', $group); @endphp
            @if($items->isNotEmpty())
                <div class="group-title">{{ $label }}</div>
                <div class="price-grid">
                    @foreach($items as $package)
                        @include('partials.price-card', ['package' => $package])
                    @endforeach
                </div>
            @endif
        @endforeach
        <p class="note" style="margin-top:30px;font-size:14px">Hosting and domain are billed separately at cost. Small projects: 50% upfront, 50% before handover. Larger projects: milestone payments. Custom quotes available for anything not listed.</p>
        <div class="card" style="margin-top:28px">
            <h3>Care &amp; security, built in</h3>
            <p>Every launch includes 30 days of free fixes. On a care plan, we apply critical security patches for PHP, Laravel and your server within 48 hours of an official advisory, plus regular updates and small changes, so your product stays safe without you having to watch the news.</p>
        </div>
    </div>
</section>

@if($faqs->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center"><span class="eyebrow">FAQ</span><h2 class="title">Questions We <span class="serif grad-text">Often Get</span></h2></div>
        <div class="faq">
            @foreach($faqs as $faq)
                <details><summary>{{ $faq->question }}</summary><p>{{ $faq->answer }}</p></details>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
