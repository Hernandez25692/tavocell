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
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->foreignId('factura_id')->nullable()->constrained('facturas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropForeign(['factura_id']);
            $table->dropColumn('factura_id');
        });
    }
};
