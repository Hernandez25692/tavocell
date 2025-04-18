<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seguimientos_reparaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reparacion_id')->constrained('reparaciones')->onDelete('cascade');
            $table->text('descripcion');
            $table->enum('estado', ['recibido', 'en_proceso', 'listo', 'entregado']);
            $table->dateTime('fecha_avance');
            $table->foreignId('tecnico_id')->constrained('users')->onDelete('cascade');
            $table->boolean('notificado')->default(false);
            $table->timestamps(); // ← Esto agrega created_at y updated_at

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos_reparaciones');
    }
};
