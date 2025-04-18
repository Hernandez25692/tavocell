<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\ProductoFactory::new();
    }

    protected $fillable = [
        'nombre',
        'categoria',
        'codigo',
        'descripcion',
        'stock',
        'precio_compra',
        'precio_venta',
        'proveedor',
        'imagen'
    ];
}
