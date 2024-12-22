<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaravelTinkering</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>
<body class="bg-black">

<!-- Header -->
@include('layouts.header')

<!-- Contingut de la pàgina -->
<main class="flex-1">
    @yield('content')
</main>

<!-- Footer -->
@include('layouts.footer')

</body>
</html>
