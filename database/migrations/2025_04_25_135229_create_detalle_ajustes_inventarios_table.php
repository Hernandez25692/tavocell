<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_ajustes_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuste_inventario_id')->constrained('ajuste_inventarios')->onDelete('cascade');
            $table->string('codigo');
            $table->string('nombre');
            $table->integer('stock_sistema');
            $table->integer('stock_fisico');
            $table->integer('diferencia');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_ajustes_inventarios');
    }
};
