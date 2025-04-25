<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAjusteInventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'ajuste_inventario_id',
        'codigo',
        'nombre',
        'stock_sistema',
        'stock_fisico',
        'diferencia',
        'observaciones',
    ];

    public function ajuste()
    {
        return $this->belongsTo(AjusteInventario::class, 'ajuste_inventario_id');
    }
}
