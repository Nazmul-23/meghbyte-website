<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · Meghbyte</title>
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body class="admin">
<div class="admin-shell">
    <nav class="side" aria-label="Admin">
        <a href="{{ route('admin.dashboard') }}" class="brand" style="padding:0"><span class="bi"><img src="{{ asset('icon.svg') }}" alt="" width="32" height="32"></span><span class="bw">megh<span>byte</span></span></a>
        <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>📊 Dashboard</a>
        <a href="{{ route('admin.leads.index') }}" @class(['active' => request()->routeIs('admin.leads.*')])>📥 Leads</a>
        <div class="sep"></div>
        @foreach(\App\Support\AdminResources::all() as $key => $def)
            <a href="{{ route('admin.resource.index', $key) }}" @class(['active' => request()->route('resource') === $key])>{{ $def['label'] }}</a>
        @endforeach
        <div class="sep"></div>
        <a href="{{ route('admin.account') }}" @class(['active' => request()->routeIs('admin.account')])>👤 My account</a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener">↗ View website</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Log out ({{ auth()->user()->name }})</button>
        </form>
    </nav>
    <main class="admin-main">
        @if(session('status'))<div class="alert alert-ok">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="alert alert-err">Please fix the errors below.</div>@endif
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}?v=1" defer></script>
</body>
</html>
