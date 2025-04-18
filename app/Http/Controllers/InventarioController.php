<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('inventario.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.codigo' => 'required|string|exists:productos,codigo',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        foreach ($request->productos as $item) {
            $producto = Producto::where('codigo', $item['codigo'])->first();
            if ($producto) {
                $producto->increment('stock', $item['cantidad']);
            }
        }

        return redirect()->route('inventario.index')->with('success', 'Inventario actualizado correctamente.');
    }
}
