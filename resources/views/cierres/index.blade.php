@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Encabezado con logo y título -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504 Logo" class="h-12">
                    <h1 class="text-3xl font-bold text-gray-800">
                        <span class="text-indigo-600">📅</span> Cierres Diarios
                    </h1>
                </div>
                
                <!-- Botón de acción principal -->
                <form method="POST" action="{{ route('cierres.store') }}" class="w-full md:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-3 rounded-lg shadow-md transition-all duration-200 hover:shadow-lg">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Realizar Cierre de Hoy
                    </button>
                </form>
            </div>

            <!-- Notificaciones -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-md flex items-center gap-3 mb-6">
                    <svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @elseif(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex items-center gap-3 mb-6">
                    <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabla de cierres -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Facturas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Reparaciones
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Ventas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Reparaciones
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Abonos
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Total Sistema
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Efectivo Físico
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Diferencia
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Responsable
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cierres as $cierre)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $cierre->fecha }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \App\Models\Factura::whereDate('created_at', $cierre->fecha)->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \App\Models\Factura::whereDate('created_at', $cierre->fecha)->whereHas('detalles', fn($q) => $q->whereNull('producto_id'))->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        L. {{ number_format($cierre->total_ventas, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        L. {{ number_format($cierre->total_reparaciones, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        L. {{ number_format($cierre->total_abonos, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                        L. {{ number_format($cierre->total_efectivo, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if (is_null($cierre->efectivo_fisico))
                                            <button onclick="abrirModal({{ $cierre->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all">
                                                Ingresar Efectivo
                                            </button>
                                        @else
                                            <span class="font-semibold text-green-600">L. {{ number_format($cierre->efectivo_fisico, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if (!is_null($cierre->efectivo_fisico))
                                            @php
                                                $diferencia = $cierre->efectivo_fisico - $cierre->total_efectivo;
                                                $diferenciaClase = $diferencia === 0 ? 'bg-green-100 text-green-800' : 
                                                                ($diferencia > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800');
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $diferenciaClase }}">
                                                L. {{ number_format(abs($diferencia), 2) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $cierre->usuario->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if (!is_null($cierre->efectivo_fisico))
                                            <form action="{{ route('cierres.descargar', $cierre->id) }}" method="POST"
                                                target="_blank" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Reporte Z
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-red-400 italic text-xs">Complete el efectivo</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal para ingresar efectivo -->
            <div id="modalEfectivo" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Registrar Efectivo Contado</h3>
                            <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <form id="formEfectivo" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="efectivo_fisico" class="block text-sm font-medium text-gray-700 mb-1">Monto en efectivo (L.)</label>
                                <input type="number" id="efectivo_fisico" name="efectivo_fisico" min="0" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="0.00" required>
                            </div>
                            
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="cerrarModal()"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function abrirModal(id) {
                    const form = document.getElementById('formEfectivo');
                    form.action = `/cierres/${id}/actualizar-efectivo`;
                    
                    const modal = document.getElementById('modalEfectivo');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    
                    // Enfocar el input al abrir el modal
                    setTimeout(() => {
                        document.getElementById('efectivo_fisico').focus();
                    }, 100);
                }

                function cerrarModal() {
                    const modal = document.getElementById('modalEfectivo');
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            </script>
        </div>
    </div>
@endsection