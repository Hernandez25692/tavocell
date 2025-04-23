@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                📅 Cierres Diarios
            </h1>

            @if (session('success'))
                <div
                    class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @elseif(session('error'))
                <div
                    class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('cierres.store') }}" class="mb-6">
                @csrf
                <button type="submit"
                    class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16" />
                    </svg>
                    Realizar Cierre de Hoy
                </button>
            </form>

            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3">Facturas</th>
                            <th class="px-6 py-3">Reparaciones</th>
                            <th class="px-6 py-3">Total Ventas</th>
                            <th class="px-6 py-3">Total Reparaciones</th>
                            <th class="px-6 py-3">Total Abonos</th>
                            <th class="px-6 py-3">Total Sistema</th>
                            <th class="px-6 py-3">Efectivo Físico</th>
                            <th class="px-6 py-3">Diferencia</th>
                            <th class="px-6 py-3">Responsable</th>
                            <th class="px-6 py-3">Reporte Z</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @foreach ($cierres as $cierre)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $cierre->fecha }}</td>
                                <td class="px-6 py-4">
                                    {{ \App\Models\Factura::whereDate('created_at', $cierre->fecha)->count() }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \App\Models\Factura::whereDate('created_at', $cierre->fecha)->whereHas('detalles', fn($q) => $q->whereNull('producto_id'))->count() }}
                                </td>
                                <td class="px-6 py-4">L. {{ number_format($cierre->total_ventas, 2) }}</td>
                                <td class="px-6 py-4">L. {{ number_format($cierre->total_reparaciones, 2) }}</td>
                                <td class="px-6 py-4">L. {{ number_format($cierre->total_abonos, 2) }}</td>
                                <td class="px-6 py-4 font-bold text-green-700">L.
                                    {{ number_format($cierre->total_efectivo, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if (is_null($cierre->efectivo_fisico))
                                        <button onclick="abrirModal({{ $cierre->id }})"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                            Ingresar Efectivo
                                        </button>
                                    @else
                                        <span class="text-green-600 font-semibold">L.
                                            {{ number_format($cierre->efectivo_fisico, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (!is_null($cierre->efectivo_fisico))
                                        @php
                                            $diferencia = $cierre->efectivo_fisico - $cierre->total_efectivo;
                                        @endphp
                                        <span
                                            class="{{ $diferencia === 0 ? 'text-green-700' : ($diferencia > 0 ? 'text-blue-600' : 'text-red-600') }} font-semibold">
                                            L. {{ number_format($diferencia, 2) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-sm">Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $cierre->usuario->name }}</td>
                                <td class="px-6 py-4">
                                    @if (!is_null($cierre->efectivo_fisico))
                                        <form action="{{ route('cierres.descargar', $cierre->id) }}" method="POST"
                                            target="_blank">
                                            @csrf
                                            <button type="submit"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">
                                                Descargar PDF
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-red-500 italic text-xs">Ingrese el efectivo físico</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Ingresar Efectivo -->
            <div id="modalEfectivo" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md mx-auto text-center">
                    <form id="formEfectivo" method="POST">
                        @csrf
                        <h2 class="text-xl font-bold mb-4">Registrar Efectivo Contado</h2>
                        <input type="number" name="efectivo_fisico" min="0" step="0.01"
                            class="w-full p-2 border rounded mb-4" placeholder="Ingrese monto físico" required>
                        <div class="flex justify-center gap-4">
                            <button type="button" onclick="cerrarModal()"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function abrirModal(id) {
                    const form = document.getElementById('formEfectivo');
                    form.action = `/cierres/${id}/actualizar-efectivo`;
                    document.getElementById('modalEfectivo').classList.remove('hidden');
                    document.getElementById('modalEfectivo').classList.add('flex');
                }

                function cerrarModal() {
                    document.getElementById('modalEfectivo').classList.remove('flex');
                    document.getElementById('modalEfectivo').classList.add('hidden');
                }
            </script>
        </div>
    </div>
@endsection
