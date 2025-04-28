@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto animate-fade-in">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    Dashboard General
                </h1>
                <div class="mt-4 md:mt-0 text-sm text-gray-500">
                    {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Ingresos del Día -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ingresos del Día</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">L. {{ number_format($ingresosTotales, 2) }}</p>
                        </div>
                        <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-green-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Hoy
                    </div>
                </div>

                <!-- Facturas Emitidas -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Facturas Emitidas</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalFacturasHoy }}</p>
                        </div>
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-blue-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Hoy
                    </div>
                </div>

                <!-- Reparaciones Activas -->
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Reparaciones Activas</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $reparacionesActivas }}</p>
                        </div>
                        <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-yellow-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        En proceso
                    </div>
                </div>


            </div>

            <!-- Gráfico de Ingresos -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Ingresos Últimos 7 Días
                    </h2>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Actualizado al minuto</span>
                </div>
                <canvas id="graficoIngresos" height="120"></canvas>
            </div>

            <!-- Alertas de Suscripciones Próximas a Vencer -->
            @if ($suscripcionesProximas->count())
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-4.293 19.07l-4.3 1.13 1.13-4.3A10 10 0 0112 2z" />
                        </svg>
                        Suscripciones Netflix Próximas a Vencer
                    </h2>

                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full table-auto text-sm text-gray-800">
                            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left">Cliente</th>
                                    <th class="px-4 py-3 text-left">Fecha Fin</th>
                                    <th class="px-4 py-3 text-left">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suscripcionesProximas as $suscripcion)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $suscripcion->cliente->nombre }}</td>
                                        <td class="px-4 py-3">
                                            {{ \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">L. {{ number_format($suscripcion->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Sección de Acciones Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('facturas_productos.create') }}"
                    class="bg-white rounded-xl shadow-md p-4 flex items-center justify-center flex-col text-center group transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:bg-blue-50">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full mb-3 group-hover:bg-blue-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">Nueva Venta</h3>
                    <p class="text-xs text-gray-500 mt-1">Productos</p>
                </a>

                <a href="{{ route('reparaciones.create') }}"
                    class="bg-white rounded-xl shadow-md p-4 flex items-center justify-center flex-col text-center group transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:bg-yellow-50">
                    <div
                        class="bg-yellow-100 text-yellow-600 p-3 rounded-full mb-3 group-hover:bg-yellow-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">Nueva Reparación</h3>
                    <p class="text-xs text-gray-500 mt-1">Registrar dispositivo</p>
                </a>

                <a href="{{ route('clientes.create') }}"
                    class="bg-white rounded-xl shadow-md p-4 flex items-center justify-center flex-col text-center group transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:bg-green-50">
                    <div
                        class="bg-green-100 text-green-600 p-3 rounded-full mb-3 group-hover:bg-green-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">Nuevo Cliente</h3>
                    <p class="text-xs text-gray-500 mt-1">Registrar en sistema</p>
                </a>

                <a href="{{ route('cierres.index') }}"
                    class="bg-white rounded-xl shadow-md p-4 flex items-center justify-center flex-col text-center group transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:bg-purple-50">
                    <div
                        class="bg-purple-100 text-purple-600 p-3 rounded-full mb-3 group-hover:bg-purple-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">Cierre Diario</h3>
                    <p class="text-xs text-gray-500 mt-1">Finalizar jornada</p>
                </a>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scroll personalizado */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Efectos hover */
        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Transiciones */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('graficoIngresos');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($ingresosPorDia->pluck('fecha')) !!},
                    datasets: [{
                        label: 'Ingresos (L.)',
                        data: {!! json_encode($ingresosPorDia->pluck('total')) !!},
                        borderColor: 'rgba(79, 70, 229, 1)',
                        backgroundColor: 'rgba(79, 70, 229, 0.05)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6,
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'L. ' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'L. ' + value;
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
