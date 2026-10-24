@php
    $services = $services ?? \App\Models\Service::published()->get(['id', 'title']);
    $selected = $selected ?? old('service_id');
@endphp
<form class="form" method="POST" action="{{ route('quote.store') }}" novalidate>
    @csrf
    <div class="hp" aria-hidden="true">
        <label for="website">Website</label>
        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>
    @if($errors->any())<div class="alert full">Please check the highlighted fields.</div>@endif
    @if(session('error'))<div class="alert full">{{ session('error') }}</div>@endif
    <div>
        <label for="name">Full name *</label>
        <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name">
        @error('name')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="150" autocomplete="email">
        @error('email')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div>
        <label for="phone">WhatsApp / phone (with country code) *</label>
        <input id="phone" name="phone" value="{{ old('phone') }}" required maxlength="20" placeholder="+1 555 123 4567" autocomplete="tel" inputmode="tel">
        @error('phone')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div>
        <label for="service_id">What do you need?</label>
        <select id="service_id" name="service_id">
            <option value="">Not sure yet</option>
            @foreach($services as $s)
                <option value="{{ $s->id }}" @selected((string) $selected === (string) $s->id)>{{ $s->title }}</option>
            @endforeach
        </select>
        @error('service_id')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="full">
        <label>Project budget</label>
        <div class="budgets">
            @foreach($budgets as $key => $label)
                <label><input type="radio" name="budget" value="{{ $key }}" @checked(old('budget') === $key)><span>{{ $label }}</span></label>
            @endforeach
        </div>
        @error('budget')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="full">
        <label for="business_name">Company or project name</label>
        <input id="business_name" name="business_name" value="{{ old('business_name') }}" maxlength="150">
        @error('business_name')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="full">
        <label for="message">Project details *</label>
        <textarea id="message" name="message" required minlength="10" maxlength="2000" placeholder="What are you building, who is it for, and when do you need it?">{{ old('message') }}</textarea>
        @error('message')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="full">
        <button class="btn btn-primary" type="submit" style="width:100%">Send inquiry <span class="arr">→</span></button>
        <p class="note">We reply within 24 hours. Your details are only used to answer your inquiry. <a href="{{ route('privacy') }}" style="color:var(--muted)">Privacy policy</a></p>
    </div>
</form>
