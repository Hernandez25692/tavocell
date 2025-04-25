<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajuste_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('codigo');
            $table->string('nombre');
            $table->integer('stock_sistema');
            $table->integer('stock_fisico');
            $table->integer('diferencia')->nullable(); // Faltante o sobrante
            $table->string('observaciones')->nullable(); // Opcional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajuste_inventarios');
    }
};
