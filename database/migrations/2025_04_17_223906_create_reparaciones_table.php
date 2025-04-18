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
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('marca');
            $table->string('modelo');
            $table->string('imei')->nullable();
            $table->text('falla_reportada');
            $table->string('accesorios')->nullable();
            $table->foreignId('tecnico_id')->constrained('users')->onDelete('cascade');
            $table->enum('estado', ['recibido', 'en_proceso', 'listo', 'entregado'])->default('recibido');
            $table->date('fecha_ingreso');
            $table->date('fecha_entrega')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};
