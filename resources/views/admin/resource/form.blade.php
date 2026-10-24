@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'New ').$def['singular'])

@section('content')
<div class="admin-top">
    <h1>{{ $item->exists ? 'Edit '.strtolower($def['singular']) : 'New '.strtolower($def['singular']) }}</h1>
    <a class="btn btn-ghost btn-sm" href="{{ route('admin.resource.index', $def['key']) }}">← Back</a>
</div>

<form class="panel" method="POST" action="{{ $item->exists ? route('admin.resource.update', [$def['key'], $item->id]) : route('admin.resource.store', $def['key']) }}">
    @csrf
    @if($item->exists) @method('PUT') @endif
    <div class="fgrid">
        @foreach($def['fields'] as $name => $field)
            @php
                $raw = $item->{$name};
                $value = old($name, match ($field['type']) {
                    'lines' => implode("\n", (array) ($raw ?? [])),
                    'datetime' => $raw ? $raw->format('Y-m-d\TH:i') : '',
                    default => $raw,
                });
                $wide = in_array($field['type'], ['textarea', 'markdown', 'lines'], true);
            @endphp
            <div @class(['wide' => $wide])>
                @if($field['type'] === 'checkbox')
                    <input type="hidden" name="{{ $name }}" value="0">
                    <label class="check-row" style="margin-top:28px"><input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $item->exists ? $raw : ($name === 'is_published'))) > {{ $field['label'] }}</label>
                @else
                    <label for="f-{{ $name }}">{{ $field['label'] }}</label>
                    @switch($field['type'])
                        @case('textarea')
                            <textarea id="f-{{ $name }}" name="{{ $name }}">{{ $value }}</textarea>
                            @break
                        @case('markdown')
                            <textarea id="f-{{ $name }}" name="{{ $name }}" class="md">{{ $value }}</textarea>
                            @break
                        @case('lines')
                            <textarea id="f-{{ $name }}" name="{{ $name }}" style="min-height:140px">{{ $value }}</textarea>
                            @break
                        @case('select')
                            <select id="f-{{ $name }}" name="{{ $name }}">
                                @foreach($field['options'] as $k => $label)<option value="{{ $k }}" @selected((string) $value === (string) $k)>{{ $label }}</option>@endforeach
                            </select>
                            @break
                        @case('number')
                            <input id="f-{{ $name }}" name="{{ $name }}" type="number" value="{{ $value }}">
                            @break
                        @case('datetime')
                            <input id="f-{{ $name }}" name="{{ $name }}" type="datetime-local" value="{{ $value }}">
                            @break
                        @default
                            <input id="f-{{ $name }}" name="{{ $name }}" value="{{ $value }}">
                    @endswitch
                @endif
                @if(!empty($field['help']))<div class="help">{{ $field['help'] }}</div>@endif
                @error($name)<div class="err">{{ $message }}</div>@enderror
            </div>
        @endforeach
    </div>
    <button class="btn btn-b" type="submit" style="margin-top:18px">{{ $item->exists ? 'Save changes' : 'Create' }}</button>
</form>

@if($item->exists && auth()->user()->isAdmin())
<form method="POST" action="{{ route('admin.resource.destroy', [$def['key'], $item->id]) }}" data-confirm="Delete this item?">
    @csrf @method('DELETE')
    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
</form>
@endif
@endsection
