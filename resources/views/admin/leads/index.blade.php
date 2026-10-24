@extends('layouts.admin')
@section('title', 'Leads')

@section('content')
<div class="admin-top">
    <h1>Leads</h1>
    <form method="GET" style="display:flex;gap:8px">
        @if($status)<input type="hidden" name="status" value="{{ $status->value }}">@endif
        <input name="q" value="{{ $search }}" placeholder="Search name, phone, business" style="width:260px">
        <button class="btn btn-b btn-sm" type="submit">Search</button>
    </form>
</div>

<div class="tabs">
    <a href="{{ route('admin.leads.index') }}" @class(['on' => ! $status])>All</a>
    @foreach($statuses as $s)
        <a href="{{ route('admin.leads.index', ['status' => $s->value]) }}" @class(['on' => $status === $s])>{{ $s->label() }}</a>
    @endforeach
</div>

<div class="panel" style="padding:0;overflow-x:auto">
    <table class="t">
        <thead><tr><th>Name</th><th>Phone</th><th>Business</th><th>Service</th><th>Budget</th><th>Status</th><th>Received</th><th></th></tr></thead>
        <tbody>
        @forelse($leads as $lead)
            <tr>
                <td><a href="{{ route('admin.leads.show', $lead) }}">{{ $lead->name }}</a></td>
                <td>{{ $lead->phone }}</td>
                <td>{{ $lead->business_name ?? '—' }}</td>
                <td>{{ $lead->service?->title ?? '—' }}</td>
                <td>{{ $lead->budgetLabel() ?? '—' }}</td>
                <td><span class="pill {{ $lead->status->color() }}">{{ $lead->status->label() }}</span></td>
                <td>{{ $lead->created_at->format('j M Y, g:i a') }}</td>
                <td><a class="btn btn-g btn-sm" href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener">WhatsApp</a></td>
            </tr>
        @empty
            <tr><td colspan="8" style="padding:24px;color:var(--muted)">No leads found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $leads->links() }}
@endsection
