<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenSeguimiento extends Model
{
    use HasFactory;

    protected $table = 'imagenes_seguimientos';

    protected $fillable = ['seguimiento_id', 'ruta_imagen'];

    public function seguimiento()
    {
        return $this->belongsTo(SeguimientoReparacion::class, 'seguimiento_id');
    }
}
