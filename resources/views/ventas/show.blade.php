@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="max-w-5xl mx-auto space-y-8">

        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            🧾 Detalle de Venta <span class="text-indigo-600">#{{ $venta->id }}</span>
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <p><strong>👤 Cliente:</strong> {{ $venta->cliente->nombre ?? 'Sin cliente' }}</p>
                <p><strong>🧑‍💼 Vendedor:</strong> {{ $venta->vendedor->name }}</p>
                <p><strong>📅 Fecha:</strong> {{ $venta->fecha_venta }}</p>
                <p>
                    <strong>💳 Método de Pago:</strong> 
                    <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 font-medium">
                        {{ $venta->metodo_pago }}
                    </span>
                </p>
                <p>
                    <strong>📄 Es Factura:</strong>
                    <span class="inline-block px-2 py-1 rounded {{ $venta->es_factura ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} font-medium">
                        {{ $venta->es_factura ? 'Sí' : 'No' }}
                    </span>
                </p>
                <p><strong>💰 Total:</strong> <span class="font-bold text-green-700 text-lg">L. {{ number_format($venta->total, 2) }}</span></p>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-2">📦 Productos Vendidos</h2>

            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Cantidad</th>
                            <th class="px-6 py-3">Precio Unitario</th>
                            <th class="px-6 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($venta->detalles as $detalle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $detalle->producto->nombre }}</td>
                                <td class="px-6 py-4">{{ $detalle->cantidad }}</td>
                                <td class="px-6 py-4">L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="px-6 py-4 font-medium text-green-700">L. {{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-between items-center mt-6">
            <a href="{{ route('ventas.factura', $venta->id) }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Descargar Factura (PDF)
            </a>

            <a href="{{ route('ventas.index') }}"
               class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition">
                ← Volver a Ventas
            </a>
        </div>
    </div>
</div>

{{-- Animación Tailwind opcional --}}
@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
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
