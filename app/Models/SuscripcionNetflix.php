<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuscripcionNetflix extends Model
{
    use HasFactory;
    protected $table = 'suscripciones_netflix';

    protected $fillable = [
        'cliente_id',
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'estado',
        'alerta_enviada',
    ];

    /**
     * Relación: Una suscripción pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
