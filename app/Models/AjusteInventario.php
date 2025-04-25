<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'codigo',
        'nombre',
        'stock_sistema',
        'stock_fisico',
        'diferencia',
        'observaciones',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
