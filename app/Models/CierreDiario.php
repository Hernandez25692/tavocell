<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreDiario extends Model
{
    use HasFactory;

    protected $table = 'cierres_diarios';

    protected $fillable = [
        'fecha',
        'total_ventas',
        'total_reparaciones',
        'total_abonos',
        'total_efectivo',
        'efectivo_fisico',
        'usuario_id',
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
