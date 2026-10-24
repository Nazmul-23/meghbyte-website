@extends('layouts.admin')
@section('title', 'My account')

@section('content')
<div class="admin-top"><h1>My account</h1></div>

<form class="panel" method="POST" action="{{ route('admin.account.update') }}">
    @csrf @method('PUT')
    <div class="fgrid">
        <div><label for="name">Name</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required>@error('name')<div class="err">{{ $message }}</div>@enderror</div>
        <div><label for="email">Email (used to log in)</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>@error('email')<div class="err">{{ $message }}</div>@enderror</div>
        <div><label for="password">New password</label><input id="password" name="password" type="password" autocomplete="new-password"><div class="help">At least 10 characters with letters and numbers. Leave empty to keep the current one.</div>@error('password')<div class="err">{{ $message }}</div>@enderror</div>
        <div><label for="password_confirmation">Repeat new password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"></div>
        <div class="wide"><label for="current_password">Current password (required to save)</label><input id="current_password" name="current_password" type="password" required autocomplete="current-password">@error('current_password')<div class="err">{{ $message }}</div>@enderror</div>
    </div>
    <button class="btn btn-b" type="submit" style="margin-top:18px">Save</button>
</form>
@endsection
