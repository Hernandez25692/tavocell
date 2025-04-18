<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:productos',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'proveedor' => 'nullable|string',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id,
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'proveedor' => 'nullable|string',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
