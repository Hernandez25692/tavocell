@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">🧾 Factura Reparación #{{ $factura->id }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <p><strong>👤 Cliente:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}</p>
                <p><strong>🧑‍💼 Vendedor:</strong> {{ $factura->usuario->name ?? 'No registrado' }}</p>
                <p><strong>📅 Fecha:</strong> {{ $factura->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>💳 Método de Pago:</strong> {{ $factura->metodo_pago }}</p>
                <p><strong>💰 Costo Total:</strong> L. {{ number_format($reparacion->costo_total ?? 0, 2) }}</p>
                <p><strong>💵 Abono:</strong> L. {{ number_format($reparacion->abono ?? 0, 2) }}</p>
                <p><strong>📉 Saldo:</strong> L. {{ number_format(($reparacion->costo_total ?? 0) - ($reparacion->abono ?? 0), 2) }}</p>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3">Costo Total</th>
                        <th class="px-6 py-3">Abono</th>
                        <th class="px-6 py-3">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $factura->detalles->first()->descripcion ?? 'Servicio de reparación' }}</td>
                        <td class="px-6 py-4">L. {{ number_format($reparacion->costo_total ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-yellow-600">L. {{ number_format($reparacion->abono ?? 0, 2) }}</td>
                        <td class="px-6 py-4 font-bold text-red-700">
                            L. {{ number_format(($reparacion->costo_total ?? 0) - ($reparacion->abono ?? 0), 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('facturas_reparaciones.pdf', $factura->id) }}" target="_blank"
               class="btn bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded-lg">
                🖨️ Imprimir PDF
            </a>
            <a href="{{ route('facturas_reparaciones.index') }}"
               class="btn bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-lg">
                ← Volver
            </a>
        </div>
    </div>
@endsection
