<!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.4-web/css/all.min.css') }}">
    <title>Shop Vue App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/app.js')
</head>

<body class="bg-light body-scroll">
    @yield('content')
</body>

<script type="application/javascript" src="{{ asset('assets/bootstrap-5.0.2-dist/js/bootstrap.min.js') }}">
import productCardInCatalog from "../../../js/components/productCardInCatalog.vue";
import wishHeart from "../../../js/components/UI/wishHeart.vue";
import modalWindow from "../../../js/components/UI/modalWindow.vue";

export default {
    productCardInCatalog,
    wishHeart,
    modalWindow
}
let exampleEl = document.getElementById('example')
let tooltip = new bootstrap.Tooltip(exampleEl, options)


</script>

</html>
