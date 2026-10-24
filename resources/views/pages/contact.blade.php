@extends('layouts.app')

@section('content')
<section class="hero page-hero">
    <div class="wrap">
        <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Contact</div>
        <h1>Get a free quote</h1>
        <p>Tell us about your business and what you need. We usually reply the same day with honest advice and a clear quote.</p>
    </div>
</section>

<section class="block">
    <div class="wrap contact-grid">
        <div class="contact-list">
            <div class="card"><h3>💬 WhatsApp</h3><p><a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">+{{ $wa }}</a></p><p>Fastest way to reach us.</p></div>
            <div class="card"><h3>📍 Location</h3><p>Hathazari, Chattogram, Bangladesh</p><p>Working with clients worldwide.</p></div>
            <div class="card"><h3>🕘 Hours</h3><p>Saturday – Thursday, 10am – 10pm (Bangladesh time)</p></div>
            <p class="bn" lang="bn">ফ্রি পরামর্শ ও ডেমোর জন্য ফর্মটি পূরণ করুন অথবা WhatsApp করুন।</p>
        </div>

        <div>
            @if(session('error'))<div class="alert alert-err">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="alert alert-err">Please check the highlighted fields.</div>@endif

            <form class="form" method="POST" action="{{ route('quote.store') }}" novalidate>
                @csrf
                <div class="hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>
                <div>
                    <label for="name">Your name *</label>
                    <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name">
                    @error('name')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="phone">Phone / WhatsApp *</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" required maxlength="20" placeholder="01XXXXXXXXX" autocomplete="tel" inputmode="tel">
                    @error('phone')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="150" autocomplete="email">
                    @error('email')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="business_name">Business name &amp; type</label>
                    <input id="business_name" name="business_name" value="{{ old('business_name') }}" maxlength="150" placeholder="e.g. coaching center, clothing shop">
                    @error('business_name')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="service_id">Service needed</label>
                    <select id="service_id" name="service_id">
                        <option value="">Not sure / Other</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" @selected((string) $selected === (string) $s->id)>{{ $s->title }}</option>
                        @endforeach
                    </select>
                    @error('service_id')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="budget">Budget</label>
                    <select id="budget" name="budget">
                        <option value="">Choose…</option>
                        @foreach($budgets as $key => $label)
                            <option value="{{ $key }}" @selected(old('budget') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('budget')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="full">
                    <label for="message">Tell us about your project *</label>
                    <textarea id="message" name="message" required minlength="10" maxlength="2000" placeholder="What does your business do, and what should the software help with?">{{ old('message') }}</textarea>
                    @error('message')<div class="err">{{ $message }}</div>@enderror
                </div>
                <div class="full">
                    <button class="btn btn-o" type="submit">Send request</button>
                    <p class="price-meta" style="margin-top:10px">We use your details only to reply to this request. See our <a href="{{ route('privacy') }}">privacy policy</a>.</p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
