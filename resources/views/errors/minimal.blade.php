<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title') | Meghbyte</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<section class="block">
    <div class="wrap" style="max-width:680px;text-align:center">
        <div style="font-size:56px;font-weight:700;color:#1E3A8A">@yield('code')</div>
        <h1 style="color:#1E3A8A;margin-top:0">@yield('message')</h1>
        <p class="sub" style="margin:0 auto 24px">@yield('detail')</p>
        <a class="btn btn-b" href="/">Go to homepage</a>
    </div>
</section>
</body>
</html>
