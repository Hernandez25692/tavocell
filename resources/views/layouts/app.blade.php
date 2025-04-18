<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TavoCell 504')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">




    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
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
