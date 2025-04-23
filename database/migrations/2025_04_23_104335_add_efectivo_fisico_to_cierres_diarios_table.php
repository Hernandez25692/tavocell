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
        Schema::table('cierres_diarios', function (Blueprint $table) {
            $table->decimal('efectivo_fisico', 10, 2)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cierres_diarios', function (Blueprint $table) {
            //
        });
    }
};
