<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscripciones_netflix', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['activo', 'vencido'])->default('activo');
            $table->boolean('alerta_enviada')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscripciones_netflix');
    }
};
