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

    @if (Auth::check())
        @include('layouts.navigation')
    @endif


    <main class="py-4 px-3 container">
        @yield('content')
    </main>
    @stack('scripts')
    <!-- Modal de Alerta Global -->
    <div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md mx-auto text-center">
            <div class="mb-4 text-red-600 text-3xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2 id="alertTitle" class="text-xl font-bold mb-2">¡Atención!</h2>
            <p id="alertMessage" class="text-gray-700 mb-4">Mensaje aquí...</p>
            <button onclick="closeAlertModal()"
                class="px-4 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600">Aceptar</button>
        </div>
    </div>


</body>

</html>

<script>
    function showAlert(title = '¡Atención!', message = 'Algo ocurrió.') {
        document.getElementById('alertTitle').innerText = title;
        document.getElementById('alertMessage').innerText = message;

        const modal = document.getElementById('alertModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAlertModal() {
        const modal = document.getElementById('alertModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
