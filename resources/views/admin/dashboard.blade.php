@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="admin-top"><h1>Dashboard</h1><a class="btn btn-b btn-sm" href="{{ route('admin.leads.index') }}">Open leads</a></div>

<div class="stats">
    <div class="stat"><div class="n">{{ $newThisWeek }}</div><div class="l">New leads this week</div></div>
    @foreach($statuses as $s)
        <a class="stat" href="{{ route('admin.leads.index', ['status' => $s->value]) }}"><div class="n">{{ $counts[$s->value] ?? 0 }}</div><div class="l">{{ $s->label() }}</div></a>
    @endforeach
</div>

<div class="panel">
    <h2 style="font-size:18px;margin:0 0 12px">Latest quote requests</h2>
    @if($latest->isEmpty())
        <p class="help" style="font-size:14px">No leads yet. They appear here when someone sends the quote form.</p>
    @else
        <table class="t">
            <thead><tr><th>Name</th><th>Phone</th><th>Service</th><th>Status</th><th>Received</th></tr></thead>
            <tbody>
            @foreach($latest as $lead)
                <tr>
                    <td><a href="{{ route('admin.leads.show', $lead) }}">{{ $lead->name }}</a></td>
                    <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->service?->title ?? '—' }}</td>
                    <td><span class="pill {{ $lead->status->color() }}">{{ $lead->status->label() }}</span></td>
                    <td>{{ $lead->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="stats">
    @foreach($contentCounts as $label => $n)
        <div class="stat"><div class="n">{{ $n }}</div><div class="l">{{ $label }}</div></div>
    @endforeach
</div>
@endsection
