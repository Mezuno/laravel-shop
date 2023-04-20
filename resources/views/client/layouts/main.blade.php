<!DOCTYPE html>
<html lang="ru" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.4-web/css/all.min.css') }}">
    <title>Shop Vue App</title>

</head>

<body class="bg-light body-scroll">
    @yield('content')
</body>

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script type="application/javascript" src="{{ asset('assets/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>

</html>
