<div @class(['pcard', 'hl' => $package->is_highlighted])>
    @if($package->is_highlighted)<span class="badge">Most popular</span>@endif
    <h3>{{ $package->name }}</h3>
    <div class="from">Starting from</div>
    <div class="amt">{{ $package->formattedPrice() }}@if($package->price_suffix)<small>{{ $package->price_suffix }}</small>@endif</div>
    @if($package->delivery)<div class="del">Delivery: {{ $package->delivery }}</div>@endif
    @if($package->features)
        <ul>@foreach($package->features as $f)<li>{{ $f }}</li>@endforeach</ul>
    @endif
    <div class="spacer"></div>
    <a class="btn {{ $package->is_highlighted ? 'btn-primary' : 'btn-ghost' }}" href="{{ route('contact') }}">Get a proposal <span class="arr">→</span></a>
</div>
