<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TavoCell 504')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1080px;
            margin: 0 auto;
        }
    </style>
    @stack('styles')

</head>
<body>

    @include('layouts.navigation') {{-- Si existe navegación --}}

    <main class="py-4 px-3 container">
        @yield('content')
    </main>
    @stack('scripts')

</body>
</html>
