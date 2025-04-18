<?php

namespace Database\Factories;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleVentaFactory extends Factory
{
    protected $model = DetalleVenta::class;

    public function definition()
    {
        $producto = Producto::inRandomOrder()->first();

        return [
            'venta_id' => Venta::inRandomOrder()->first()->id ?? 1,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad = rand(1, 3),
            'precio_unitario' => $producto->precio_venta,
            'subtotal' => $producto->precio_venta * $cantidad,
        ];
    }
}
