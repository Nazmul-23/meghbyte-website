@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Pricing</div>
        <h1>Simple packages, honest prices</h1>
        <p>These are starting prices. You always get a written quotation for your exact scope before any work starts.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        @foreach(\App\Models\PricingPackage::GROUPS as $group => $label)
            @php $items = $packages->where('group', $group); @endphp
            @if($items->isNotEmpty())
                <h2 style="margin-top:{{ $loop->first ? 0 : 48 }}px">{{ $label }}</h2>
                <div class="grid3" style="margin-top:24px">
                    @foreach($items as $package)
                        @include('partials.price-card', ['package' => $package])
                    @endforeach
                </div>
            @endif
        @endforeach
        <p class="note">Domain and hosting are quoted separately per year. International clients: we quote in USD per project. Payment: 50% advance and 50% before handover for smaller projects; milestones for larger ones.</p>
    </div>
</section>

@if($faqs->isNotEmpty())
<section class="block alt">
    <div class="wrap" style="max-width:860px">
        <div class="eyebrow">FAQ</div>
        <h2>Questions we often get</h2>
        <div style="margin-top:24px">
            @foreach($faqs as $faq)
                <details><summary>{{ $faq->question }}</summary><p>{{ $faq->answer }}</p></details>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
