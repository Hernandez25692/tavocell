<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoReparacion extends Model
{
    use HasFactory;

    protected $table = 'seguimientos_reparaciones';

    protected $fillable = [
        'reparacion_id',
        'descripcion',
        'estado',
        'fecha_avance',
        'tecnico_id',
        'notificado'
    ];

    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }
}
