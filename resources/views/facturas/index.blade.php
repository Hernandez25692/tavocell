@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            📄 Historial de Facturas
        </h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                ✅ <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tabs -->
        <ul class="flex border-b mb-6" id="tabs">
            <li class="mr-2">
                <a href="#productos" class="tablink inline-block py-2 px-4 text-blue-600 border-b-2 border-blue-600 font-semibold">🛒 Productos</a>
            </li>
            <li>
                <a href="#reparaciones" class="tablink inline-block py-2 px-4 text-gray-600 hover:text-blue-600 border-b-2 border-transparent hover:border-blue-600 font-semibold">🔧 Reparaciones</a>
            </li>
        </ul>

        <!-- Productos -->
        <div id="productos">
            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($facturasProductos as $factura)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $factura->id }}</td>
                                <td class="px-6 py-4">{{ $factura->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4">{{ optional($factura->cliente)->nombre ?? 'Consumidor Final' }}</td>
                                <td class="px-6 py-4 font-bold text-green-700">L. {{ number_format($factura->total, 2) }}</td>
                                <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                    <a href="{{ route('facturas.show', $factura->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm shadow">Ver</a>
                                    <a href="{{ route('facturas.pdf', $factura->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm shadow">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Reparaciones -->
        <div id="reparaciones" class="hidden">
            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200 mt-6">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Costo Total</th>
                            <th class="px-6 py-3">Abono</th>
                            <th class="px-6 py-3">Saldo</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($facturasReparaciones as $factura)
                            @php
                                $reparacion = \App\Models\Reparacion::where('factura_id', $factura->id)->first();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $factura->id }}</td>
                                <td class="px-6 py-4">{{ $factura->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4">{{ optional($factura->cliente)->nombre ?? 'Consumidor Final' }}</td>
                                <td class="px-6 py-4">{{ $factura->detalles->first()->descripcion ?? 'Servicio' }}</td>
                                <td class="px-6 py-4 font-medium">L. {{ number_format($reparacion->costo_total ?? 0, 2) }}</td>
                                <td class="px-6 py-4 font-medium text-yellow-600">L. {{ number_format($reparacion->abono ?? 0, 2) }}</td>
                                <td class="px-6 py-4 font-bold text-red-700">
                                    L. {{ number_format(($reparacion->costo_total ?? 0) - ($reparacion->abono ?? 0), 2) }}
                                </td>
                                <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                    <a href="{{ route('facturas.show', $factura->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm shadow">Ver</a>
                                    <a href="{{ route('facturas.pdf', $factura->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm shadow">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const tabs = document.querySelectorAll('.tablink');
    const contents = ['#productos', '#reparaciones'];

    tabs.forEach((tab, i) => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('text-blue-600', 'border-blue-600'));
            this.classList.add('text-blue-600', 'border-blue-600');

            contents.forEach(id => document.querySelector(id).classList.add('hidden'));
            document.querySelector(contents[i]).classList.remove('hidden');
        });
    });
</script>
@endpush
@endsection
