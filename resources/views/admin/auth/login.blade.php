<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin login · Meghbyte</title>
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="brand" style="margin-bottom:18px"><span class="bi"><img src="{{ asset('icon.svg') }}" alt="" width="32" height="32"></span><span class="bw">megh<span>byte</span></span></div>
        <h1 style="font-size:22px;margin:0 0 18px">Admin login</h1>
        @if($errors->any())<div class="alert alert-err">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.login.attempt') }}" style="display:grid;gap:14px">
            @csrf
            <div><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" autofocus></div>
            <div><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
            <label class="check-row" style="font-weight:500"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="btn btn-b" type="submit">Sign in</button>
        </form>
    </div>
</div>
</body>
</html>
