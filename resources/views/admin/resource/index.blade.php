@extends('layouts.admin')
@section('title', $def['label'])

@section('content')
<div class="admin-top">
    <h1>{{ $def['label'] }}</h1>
    <a class="btn btn-b btn-sm" href="{{ route('admin.resource.create', $def['key']) }}">+ New {{ strtolower($def['singular']) }}</a>
</div>

<div class="panel" style="padding:0;overflow-x:auto">
    <table class="t">
        <thead><tr>@foreach($def['columns'] as $label)<th>{{ $label }}</th>@endforeach<th></th></tr></thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                @foreach($def['columns'] as $col => $label)
                    @php $v = $item->{$col}; @endphp
                    <td>
                        @if(is_bool($v)){{ $v ? 'Yes' : 'No' }}
                        @elseif($v instanceof \DateTimeInterface){{ $v->format('j M Y') }}
                        @elseif($col === 'price')${{ number_format((int) $v) }}
                        @else{{ \Illuminate\Support\Str::limit((string) $v, 70) }}
                        @endif
                    </td>
                @endforeach
                <td style="white-space:nowrap">
                    <a class="btn btn-ghost btn-sm" href="{{ route('admin.resource.edit', [$def['key'], $item->id]) }}">Edit</a>
                    @if($def['public_route'] && $item->slug)
                        <a class="btn btn-ghost btn-sm" href="{{ route($def['public_route'], $item->slug) }}" target="_blank" rel="noopener">View</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ count($def['columns']) + 1 }}" style="padding:24px;color:var(--muted)">Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $items->links() }}
@endsection
