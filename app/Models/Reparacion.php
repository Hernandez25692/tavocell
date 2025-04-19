<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    use HasFactory;

    // ✅ IMPORTANTE: declarar nombre exacto de la tabla
    protected $table = 'reparaciones';

    protected $fillable = [
        'cliente_id',
        'marca',
        'modelo',
        'imei',
        'falla_reportada',
        'accesorios',
        'tecnico_id',
        'fecha_ingreso',
        'costo_total',
        'abono',
        'estado',
        'factura_id',
    ];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoReparacion::class);
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
