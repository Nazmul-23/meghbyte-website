@extends('layouts.admin')
@section('title', 'Lead: '.$lead->name)

@section('content')
<div class="admin-top">
    <h1>{{ $lead->name }}</h1>
    <div class="cta-row">
        <a class="btn btn-g btn-sm" href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener">💬 WhatsApp</a>
        <a class="btn btn-ghost btn-sm" href="{{ route('admin.leads.index') }}">← All leads</a>
    </div>
</div>

<div class="panel">
    <dl class="dl">
        <dt>Status</dt><dd><span class="pill {{ $lead->status->color() }}">{{ $lead->status->label() }}</span></dd>
        <dt>Phone</dt><dd>{{ $lead->phone }}</dd>
        <dt>Email</dt><dd>{{ $lead->email ?? '—' }}</dd>
        <dt>Business</dt><dd>{{ $lead->business_name ?? '—' }}</dd>
        <dt>Service</dt><dd>{{ $lead->service?->title ?? 'Not sure / Other' }}</dd>
        <dt>Budget</dt><dd>{{ $lead->budgetLabel() ?? '—' }}</dd>
        <dt>Received</dt><dd>{{ $lead->created_at->format('j M Y, g:i a') }}</dd>
        <dt>First contacted</dt><dd>{{ $lead->contacted_at?->format('j M Y, g:i a') ?? '—' }}</dd>
        <dt>Came from</dt><dd>{{ $lead->source_page ?: '—' }}</dd>
    </dl>
    <h3 style="margin:22px 0 8px">Message</h3>
    <p style="white-space:pre-line;margin:0">{{ $lead->message }}</p>
</div>

<form class="panel" method="POST" action="{{ route('admin.leads.update', $lead) }}">
    @csrf @method('PUT')
    <div class="fgrid">
        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                @foreach($statuses as $s)<option value="{{ $s->value }}" @selected($lead->status === $s)>{{ $s->label() }}</option>@endforeach
            </select>
        </div>
        <div class="wide">
            <label for="notes">Internal notes</label>
            <textarea id="notes" name="notes" maxlength="5000">{{ old('notes', $lead->notes) }}</textarea>
            @error('notes')<div class="err">{{ $message }}</div>@enderror
        </div>
    </div>
    <button class="btn btn-b" type="submit" style="margin-top:14px">Save</button>
</form>

@if(auth()->user()->isAdmin())
<form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" data-confirm="Delete this lead?">
    @csrf @method('DELETE')
    <button class="btn btn-danger btn-sm" type="submit">Delete lead</button>
</form>
@endif
@endsection
