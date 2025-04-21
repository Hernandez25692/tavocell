@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">📊 Dashboard General</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Ingresos del Día</p>
            <p class="text-2xl font-bold text-green-600">L. {{ number_format($ingresosTotales, 2) }}</p>
        </div>
        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Facturas Emitidas Hoy</p>
            <p class="text-2xl font-bold">{{ $totalFacturasHoy }}</p>
        </div>
        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Reparaciones Activas</p>
            <p class="text-2xl font-bold text-yellow-500">{{ $reparacionesActivas }}</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4">
        <p class="text-sm text-gray-500 mb-2">Ingresos Últimos 7 Días</p>
        <canvas id="graficoIngresos" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoIngresos');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ingresosPorDia->pluck('fecha')) !!},
            datasets: [{
                label: 'Ingresos',
                data: {!! json_encode($ingresosPorDia->pluck('total')) !!},
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderWidth: 2,
                tension: 0.4
            }]
        }
    });
</script>
@endpush
