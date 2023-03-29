<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.4-web/css/all.min.css') }}">
    <title>Shop Vue App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['/public/assets/css/cart.css'])
    @vite(['/public/assets/css/hover-image.css'])
    @vite('resources/css/app.css')
</head>

<body>
@vite('resources/js/app.js')
    @yield('content')
</body>

    <script type="module" src="{{ asset('main.js') }}"></script>
    <script type="application/javascript" src="{{ asset('assets/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
</html>
