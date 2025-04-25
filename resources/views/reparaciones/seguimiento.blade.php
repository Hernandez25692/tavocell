@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10 animate-fade-in">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="max-w-5xl mx-auto space-y-10">

            <!-- ENCABEZADO -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">📱 Seguimiento de Reparación #{{ $reparacion->id }}</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <p><span class="font-semibold">👤 Cliente:</span> {{ $reparacion->cliente->nombre }}</p>
                    <p><span class="font-semibold">📱 Dispositivo:</span> {{ $reparacion->marca }} {{ $reparacion->modelo }}
                    </p>
                    <p><span class="font-semibold">🔢 IMEI:</span> {{ $reparacion->imei ?? 'No registrado' }}</p>
                    <p>
                        <span class="font-semibold">📍 Estado actual:</span>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-bold border shadow-sm
                        {{ match ($reparacion->estado) {
                            'pendiente' => 'bg-red-100 text-red-700 border-red-400',
                            'en_proceso', 'en proceso' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
                            'listo' => 'bg-green-100 text-green-700 border-green-400',
                            'entregado' => 'bg-blue-100 text-blue-700 border-blue-400',
                            default => 'bg-gray-100 text-gray-700 border-gray-300',
                        } }}">
                            {{ ucfirst(str_replace('_', ' ', $reparacion->estado)) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- FORMULARIO DE AVANCE -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Nuevo Avance Técnico</h2>
                <form action="{{ route('seguimientos.store', $reparacion) }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del avance:</label>
                        <textarea name="descripcion" required rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none shadow-sm"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="imagenes[]" class="block font-semibold text-gray-700">Subir imágenes del
                            seguimiento</label>
                        <input type="file" name="imagenes[]" multiple accept="image/*"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <p class="text-xs text-gray-500 mt-1">Puedes subir varias imágenes del estado actual del equipo.</p>
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
                        <select name="estado" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white">
                            <option value="recibido">Recibido</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="listo">Listo</option>
                            <option value="entregado">Entregado</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition-all duration-200">
                        Guardar Avance
                    </button>
                </form>
            </div>

            @php
                $pendiente = $reparacion->costo_total - $reparacion->abono;
            @endphp

            @if ($pendiente > 0 && !$reparacion->factura_id)
                <!-- Mostrar alerta de saldo pendiente y formulario para abonar -->
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 px-4 py-3 rounded mt-4">
                    ⚠️ El cliente aún debe <strong>L. {{ number_format($pendiente, 2) }}</strong>.
                    Debe pagar la totalidad antes de marcar como "Entregado" y generar factura.
                </div>

                <div class="bg-white p-4 rounded-lg shadow mt-6 border border-yellow-300">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">➕ Registrar Abono Adicional</h3>
                    <form action="{{ route('reparaciones.abonar', $reparacion) }}" method="POST"
                        class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        <input type="number" name="monto" step="0.01" min="1" max="{{ $pendiente }}"
                            class="border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto"
                            placeholder="L. abonar">
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-md shadow">
                            Agregar Abono
                        </button>
                    </form>
                </div>
            @elseif($reparacion->estado === 'entregado' && !$reparacion->factura_id)
                <!-- Ya pagó todo, permitir facturación -->
                <form method="POST" action="{{ route('facturar.reparacion', $reparacion->id) }}" class="mt-6">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
                        💸 Generar Factura de Reparación
                    </button>
                </form>
            @elseif($reparacion->factura_id)
                <!-- Ya tiene factura, mostrar botón de descarga -->
                <a href="{{ route('facturas_reparaciones.pdf', $reparacion->factura_id) }}" target="_blank"
                    class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    🧾 Descargar Factura PDF
                </a>
            @endif





            <!-- HISTORIAL DE AVANCES (TIMELINE) -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-6">📋 Historial de Seguimiento</h2>
                <ul class="relative border-l-4 border-indigo-300 pl-6 space-y-6">
                    @forelse($reparacion->seguimientos as $seg)
                        <li class="relative">
                            <div
                                class="absolute -left-3 top-1 w-6 h-6 bg-indigo-500 rounded-full border-4 border-white shadow">
                            </div>
                            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 shadow-sm space-y-2">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span><strong>Fecha:</strong>
                                        {{ $seg->created_at->isoFormat('D MMM YYYY, h:mm a') }}</span>
                                    <span><strong>Estado:</strong>
                                        {{ ucfirst(str_replace('_', ' ', $seg->estado)) }}</span>
                                </div>
                                <p class="text-gray-800 mb-1"><strong>Técnico:</strong> {{ $seg->tecnico->name }}</p>
                                <p class="text-gray-700 text-sm">{{ $seg->descripcion }}</p>

                                @if ($seg->imagenes && $seg->imagenes->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-2">
                                        @foreach ($seg->imagenes as $img)
                                            <a href="{{ asset('storage/' . $img->ruta_imagen) }}" target="_blank"
                                                class="block group">
                                                <div
                                                    class="overflow-hidden rounded-lg border border-gray-300 shadow-sm group-hover:shadow-md transition">
                                                    <img src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                        alt="Imagen seguimiento"
                                                        class="w-full h-40 object-cover object-center transition duration-300 group-hover:scale-105">
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                            </div>

                        </li>
                    @empty
                        <li class="text-gray-500 italic">No hay avances registrados aún.</li>
                    @endforelse
                </ul>
            </div>
            <!-- HISTORIAL DE ABONOS -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-2">💰 Historial de Abonos</h2>

                <p class="mb-4 text-sm text-gray-600">
                    💵 <span class="font-semibold">Costo Total de la Reparación:</span>
                    L. {{ number_format($reparacion->costo_total, 2) }}
                </p>

                @php
                    $abonado = $reparacion->abonos->sum('monto');
                    $porcentaje = $reparacion->costo_total > 0 ? ($abonado / $reparacion->costo_total) * 100 : 0;
                @endphp

                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1 font-medium">
                        🔄 <span class="text-indigo-700">Progreso de pago:</span> L. {{ number_format($abonado, 2) }} /
                        {{ number_format($reparacion->costo_total, 2) }}
                    </p>
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="bg-indigo-600 h-4 text-xs text-white text-center leading-4 transition-all duration-500"
                            style="width: {{ $porcentaje }}%">
                            {{ number_format($porcentaje, 0) }}%
                        </div>
                    </div>
                </div>

                @if ($reparacion->abonos->isEmpty())
                    <p class="text-gray-500 italic">No hay abonos registrados para esta reparación.</p>
                @else
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg shadow">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Monto (L.)</th>
                                    <th class="px-4 py-2">Método de Pago</th>
                                    <th class="px-4 py-2">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($reparacion->abonos as $abono)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $abono->created_at->format('d/m/Y h:i A') }}</td>
                                        <td class="px-4 py-2 font-semibold text-green-700">L.
                                            {{ number_format($abono->monto, 2) }}</td>
                                        <td class="px-4 py-2">{{ $abono->metodo_pago ?? 'Agregado manual' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $abono->observaciones ?? 'Desde la vista Seguimiento' }}
                                            @if ($abono->usuario)
                                                <br><span class="text-xs text-gray-500 italic">Registrado por:
                                                    {{ $abono->usuario->name }}</span>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>


            <!-- BOTÓN VOLVER -->
            <div class="text-right">
                <a href="{{ route('reparaciones.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium shadow-sm transition">
                    ← Volver a la lista
                </a>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
@endsection
