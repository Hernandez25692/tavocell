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
                <h1 class="text-3xl font-bold text-gray-800 mb-4">📱 Seguimiento de Reparación</h1>
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
                            'en_proceso', 'en_proceso' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
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
                        <input type="number" name="nuevo_abono" step="0.01" min="1" max="{{ $pendiente }}"
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
            @endif






            <!-- HISTORIAL DE AVANCES (TIMELINE) -->
            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Historial de Seguimiento
                </h2>

                <ul class="relative border-l-4 border-indigo-300 pl-6 space-y-8">
                    @forelse($reparacion->seguimientos as $seg)
                        <li class="relative">
                            <!-- Punto de línea de tiempo -->
                            <div
                                class="absolute -left-3 top-1 w-6 h-6 bg-indigo-600 rounded-full border-4 border-white shadow-md z-10">
                            </div>

                            <!-- Tarjeta de seguimiento -->
                            <div
                                class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 shadow-md hover:shadow-lg transition-all">
                                <div
                                    class="flex flex-col md:flex-row justify-between md:items-center text-sm text-gray-600 mb-3 gap-2">
                                    <div><strong>📅 Fecha:</strong> {{ $seg->created_at->isoFormat('D MMM YYYY, h:mm a') }}
                                    </div>
                                    <div><strong>📌 Estado:</strong> {{ ucfirst(str_replace('_', ' ', $seg->estado)) }}
                                    </div>
                                    <div><strong>👨‍🔧 Técnico:</strong> {{ $seg->tecnico->name ?? 'Sistema' }}</div>
                                </div>
                                <div><strong>Descripción del avance:</strong>
                                <p class="text-gray-800 text-sm leading-relaxed mb-2">
                                    {{ $seg->descripcion }}
                                </p>

                                @if ($seg->imagenes && $seg->imagenes->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                                        @foreach ($seg->imagenes as $img)
                                            <a href="{{ asset('storage/' . $img->ruta_imagen) }}" target="_blank"
                                                class="block group">
                                                <div
                                                    class="overflow-hidden rounded-lg border border-gray-300 shadow-sm group-hover:shadow-lg transition">
                                                    <img src="{{ asset('storage/' . $img->ruta_imagen) }}"
                                                        alt="Imagen seguimiento"
                                                        class="w-full h-40 object-cover object-center group-hover:scale-105 transition duration-300">
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
