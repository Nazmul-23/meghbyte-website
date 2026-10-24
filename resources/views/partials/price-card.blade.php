<div @class(['card', 'price-card', 'hl' => $package->is_highlighted])>
    @if($package->is_highlighted)<span class="badge">Most popular</span>@endif
    <h3>{{ $package->name }}</h3>
    <div class="price-meta">Starting from</div>
    <div class="price">{{ $package->formattedPrice() }}@if($package->price_suffix)<small>{{ $package->price_suffix }}</small>@endif</div>
    @if($package->delivery)<div class="price-meta">Delivery: {{ $package->delivery }}</div>@endif
    @if($package->features)
        <ul class="check">
            @foreach($package->features as $f)<li>{{ $f }}</li>@endforeach
        </ul>
    @endif
    <div style="margin-top:auto;padding-top:18px">
        <a class="btn {{ $package->is_highlighted ? 'btn-o' : 'btn-ghost' }} btn-sm" href="{{ route('contact') }}">Get a quote</a>
    </div>
</div>
