<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonoReparacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'reparacion_id',
        'monto',
        'metodo_pago',
        'observaciones',
        'usuario_id',
    ];


    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
