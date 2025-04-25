<?php

namespace App\Http\Controllers;

use App\Models\AjusteInventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjusteInventarioController extends Controller
{
    public function index()
    {
        $ajustes = AjusteInventario::orderByDesc('created_at')->paginate(10);
        return view('ajustes_inventario.index', compact('ajustes'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('ajustes_inventario.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ajustes' => 'required|array|min:1',
            'ajustes.*.codigo' => 'required|string',
            'ajustes.*.nombre' => 'required|string',
            'ajustes.*.stock_sistema' => 'required|integer|min:0',
            'ajustes.*.stock_fisico' => 'required|integer|min:0',
        ]);

        foreach ($request->ajustes as $item) {
            AjusteInventario::create([
                'usuario_id' => Auth::id(),
                'codigo' => $item['codigo'],
                'nombre' => $item['nombre'],
                'stock_sistema' => $item['stock_sistema'],
                'stock_fisico' => $item['stock_fisico'],
                'diferencia' => $item['stock_fisico'] - $item['stock_sistema'],
                'observaciones' => $item['observaciones'] ?? null,
            ]);
        }

        return redirect()->route('ajustes-inventario.index')->with('success', 'Ajuste de inventario registrado correctamente.');
    }

    public function show($id)
    {
        $ajuste = AjusteInventario::findOrFail($id);
        return view('ajustes_inventario.show', compact('ajuste'));
    }
}
