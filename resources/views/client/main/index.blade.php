<!DOCTYPE html>
<html lang="ru" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico?v={{ strtotime(now()) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.4-web/css/all.min.css') }}">
    <title>Store</title>

    @vite(['resources/css/app.scss'])

</head>

<body class="bg-light body-scroll">
    <div id="app" style="min-height: 100vh">

    </div>
</body>

    @vite(['resources/js/app.js'])

</html>
