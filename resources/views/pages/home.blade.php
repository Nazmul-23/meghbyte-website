@extends('layouts.app')

@push('head')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    'name' => 'Meghbyte',
    'description' => 'Software studio building websites, mobile apps and custom business software.',
    'url' => url('/'),
    'telephone' => '+'.$wa,
    'areaServed' => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@php
    $tech = ['Laravel', 'PHP', 'Flutter', 'Dart', 'PostgreSQL', 'MySQL', 'Livewire', 'Tailwind CSS', 'Firebase', 'REST APIs', 'Stripe', 'PayPal', 'Figma', 'GitHub', 'Docker', 'Cloudflare'];
@endphp

@section('content')
{{-- HERO --}}
<section class="hero">
    <div class="wrap">
        <span class="eyebrow">Founder-led software studio</span>
        <h1>We Build <span class="serif">Software</span> That Grows Your <span class="serif grad-text">Business</span></h1>
        <div class="tagpill">Websites · Mobile Apps · Custom Systems</div>
        <p class="lead">{{ $home['hero_subtitle'] ?? 'We design and build websites, e-commerce stores, mobile apps and custom business systems for founders and growing companies worldwide.' }}</p>
        <div class="ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Start your project <span class="arr">→</span></a>
            <a class="btn btn-ghost" href="{{ route('work.index') }}">See our work</a>
        </div>
    </div>
    <div class="showcase" aria-hidden="true">
        <div class="shot">
            <div class="t">Online store · This month</div>
            <div class="k"><b>$12,480<small>Revenue</small></b><b>326<small>Orders</small></b></div>
            <svg viewBox="0 0 160 50"><path d="M0 42 L20 36 L40 39 L60 26 L80 30 L100 17 L120 21 L140 9 L160 11" fill="none" stroke="#34D399" stroke-width="3"/></svg>
            <div class="sub up">+18.2% vs last month</div>
        </div>
        <div class="shot light">
            <div class="t">Attendance · HSC-1 · Today</div>
            <ul class="rows">
                <li><span>Tanvir Ahmed</span><em class="ok">Present</em></li>
                <li><span>Nusrat Jahan</span><em class="ok">Present</em></li>
                <li><span>Sadia Akter</span><em class="no">Absent</em></li>
                <li><span>Arif Hossain</span><em class="ok">Present</em></li>
            </ul>
            <div class="sub">Guardian SMS sent · 10:15</div>
        </div>
        <div class="shot">
            <div class="phone">
                <div class="ph-h">Order #2081</div>
                <div class="ph-i"><span>Cotton kurti × 2</span><b>$48</b></div>
                <div class="ph-i"><span>Delivery</span><b>$4</b></div>
                <div class="ph-i tot"><span>Total</span><b>$52</b></div>
                <div class="ph-s">Out for delivery</div>
                <div class="ph-btn">Track order</div>
            </div>
        </div>
        <div class="shot">
            <div class="code"><span class="kw">Route</span>::post(<span class="st">'/orders'</span>, ...);<br><br><span class="kw">class</span> Invoice <span class="kw">extends</span> Model<br>{<br>&nbsp;&nbsp;<span class="cm">// clean, tested code</span><br>&nbsp;&nbsp;<span class="kw">public function</span> total()<br>}</div>
            <div class="sub up">✓ 48 tests passed</div>
        </div>
        <div class="shot grad">
            <div class="t" style="color:#fff">Quotation #1042</div>
            <ul class="rows inv">
                <li><span>Website design</span><b>$900</b></li>
                <li><span>Admin panel</span><b>$1,100</b></li>
                <li><span>Hosting setup</span><b>$450</b></li>
            </ul>
            <div class="inv-t"><span>Total</span>$2,450</div>
            <div class="inv-b">Approve &amp; pay 50%</div>
        </div>
    </div>
</section>

{{-- TECH MARQUEE --}}
<section class="trust">
    <p>Built with tools trusted by teams worldwide</p>
    <div class="marquee"><div class="track">
        @foreach(array_merge($tech, $tech) as $t)<span>{{ $t }}</span>@endforeach
    </div></div>
</section>

{{-- CASE STUDIES --}}
@if($projects->isNotEmpty())
<section class="sec">
    <div class="wrap center">
        <span class="eyebrow">Selected work</span>
        <h2 class="title">Products We <span class="serif grad-text">Build</span></h2>
        <p class="lead" style="margin-top:16px">Real screens from the systems we are building: a school and coaching management system and a Laravel online store.</p>
    </div>
    <div class="wrap">
        <div class="cases">
            @foreach($projects as $project)
                @include('partials.project-card', ['project' => $project])
            @endforeach
        </div>
        <div class="center" style="margin-top:34px"><a class="btn btn-ghost" href="{{ route('work.index') }}">See all projects <span class="arr">→</span></a></div>
    </div>
</section>
@endif

{{-- SERVICES --}}
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">What we do</span>
            <h2 class="title">Everything You Need to <span class="serif grad-text">Launch &amp; Grow</span></h2>
        </div>
        <div class="svc-grid">
            @foreach($services as $service)
                <a class="svc" href="{{ route('services.show', $service->slug) }}">
                    <div class="ic" aria-hidden="true">{{ $service->icon }}</div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->summary }}</p>
                    @if($service->features)
                        <ul>@foreach(array_slice($service->features, 0, 4) as $f)<li>{{ $f }}</li>@endforeach</ul>
                    @endif
                    @if($service->price_note)<div class="price">{{ $service->price_note }}</div>@endif
                    <span class="more">Explore service →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- WHY US (BENTO) --}}
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">Why choose us</span>
            <h2 class="title">Built Around <span class="serif grad-text">Your Success</span></h2>
        </div>
        <div class="bento">
            <div class="b s3 hl wide">
                <h3>Flexible payments</h3>
                <p>Pay by milestone as each part is approved. No large upfront risk.</p>
                <div class="seg"><span>Milestones</span><span class="on">50 / 50</span><span>Monthly plan</span></div>
            </div>
            <div class="b s3 wide">
                <h3>Fixed scope, fixed price</h3>
                <p>A written proposal before any work starts: what you get, when it ships and what it costs. No surprise invoices.</p>
            </div>
            <div class="b s2">
                <h3>Weekly demos</h3>
                <p>A live link to the latest version every week, so you can steer the product while it is being built.</p>
            </div>
            <div class="b s2">
                <div class="big">30 <small>days</small></div>
                <h3 style="margin-top:6px">Free fixes after launch</h3>
                <p>Plus an optional care plan for updates, backups and small changes.</p>
            </div>
            <div class="b s2">
                <h3>Direct access to the builder</h3>
                <p>No account-manager layers. You talk to the people writing your code.</p>
            </div>
            <div class="b s4 wide">
                <h3>A modern, proven stack</h3>
                <p>We pick mature tools with large communities, so your product is easy to maintain and hire for later.</p>
                <div class="stack">@foreach(['Laravel', 'Flutter', 'PostgreSQL', 'Livewire', 'Tailwind CSS', 'Firebase', 'Docker'] as $t)<span>{{ $t }}</span>@endforeach</div>
            </div>
            <div class="b s2">
                <h3>NDA on request</h3>
                <p>Your idea stays yours. We are happy to sign an NDA before you share details.</p>
            </div>
        </div>
    </div>
</section>

{{-- PROCESS --}}
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">How we work</span>
            <h2 class="title">From Idea to Launch in <span class="serif grad-text">Four Steps</span></h2>
        </div>
        <div class="steps">
            <div class="step"><h3>Discovery call</h3><p>A free 30-minute call to understand your goals, users and timeline.</p></div>
            <div class="step"><h3>Proposal</h3><p>A written scope, fixed price and milestone plan within 48 hours.</p></div>
            <div class="step"><h3>Design &amp; build</h3><p>UI/UX first, then development, with a demo link every week.</p></div>
            <div class="step"><h3>Launch &amp; support</h3><p>We deploy, hand over, train your team and fix issues free for 30 days.</p></div>
        </div>
    </div>
</section>

{{-- COMPARISON --}}
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">Compare your options</span>
            <h2 class="title">Why Not Hire In-House <span class="serif grad-text">or a Freelancer?</span></h2>
        </div>
        <div class="compare"><div class="scroll-x">
            <table>
                <thead><tr><th>Option</th><th>Cost</th><th>Speed</th><th>Reliability</th><th>Support</th></tr></thead>
                <tbody>
                    <tr class="us"><td>Meghbyte<small>Small senior team, fixed price</small></td><td class="y">Affordable, fixed</td><td class="y">Weeks</td><td class="y">Written scope + weekly demos</td><td class="y">30 days free + care plan</td></tr>
                    <tr><td>In-house hire<small>Full-time developer</small></td><td class="n">Salary + benefits</td><td class="n">Months to hire</td><td>Depends on one person</td><td>While they stay</td></tr>
                    <tr><td>Large agency<small>Structured, but heavy</small></td><td class="n">High</td><td>Long timelines</td><td class="y">Good</td><td>Often extra cost</td></tr>
                    <tr><td>Freelancer<small>Budget-friendly</small></td><td class="y">Low</td><td>Varies</td><td class="n">Inconsistent</td><td class="n">Often limited</td></tr>
                    <tr><td>DIY builders<small>Website builders &amp; templates</small></td><td class="y">Low</td><td class="y">Fast</td><td class="n">Limited by templates</td><td class="n">You are on your own</td></tr>
                </tbody>
            </table>
        </div></div>
    </div>
</section>

{{-- PRICING TEASER --}}
@if($packages->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">Pricing</span>
            <h2 class="title">Clear Prices, <span class="serif grad-text">No Surprises</span></h2>
            <p class="lead" style="margin-top:16px">Starting prices in USD. Every project gets a written proposal for its exact scope.</p>
        </div>
        <div class="price-grid">
            @foreach($packages as $package)
                @include('partials.price-card', ['package' => $package])
            @endforeach
        </div>
        <div class="center" style="margin-top:30px"><a class="btn btn-ghost" href="{{ route('pricing') }}">See all packages <span class="arr">→</span></a></div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if($faqs->isNotEmpty())
<section class="sec" style="padding-top:20px">
    <div class="wrap">
        <div class="center">
            <span class="eyebrow">FAQ</span>
            <h2 class="title">Your Questions, <span class="serif grad-text">Answered</span></h2>
        </div>
        <div class="faq">
            @foreach($faqs as $faq)
                <details @if($loop->first) open @endif><summary>{{ $faq->question }}</summary><p>{{ $faq->answer }}</p></details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CONTACT --}}
<section class="sec" id="contact" style="padding-top:20px">
    <div class="wrap contact">
        <div class="offer">
            <span class="eyebrow">Free consultation</span>
            <h2 style="margin-top:18px">Let's Talk About <span class="serif">Your Project</span></h2>
            <ul>
                <li>Reply within 24 hours</li>
                <li>Free 30-minute discovery call</li>
                <li>Written proposal with a fixed price</li>
                <li>Happy to sign an NDA on request</li>
            </ul>
            <div class="wa">Prefer chat? <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">Message us on WhatsApp →</a></div>
        </div>
        @include('partials.quote-form', ['budgets' => $budgets])
    </div>
</section>
@endsection
