<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'total',
        'metodo_pago',
        'vendedor_id',
        'es_factura'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class);
    }

    public function vendedor() {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
