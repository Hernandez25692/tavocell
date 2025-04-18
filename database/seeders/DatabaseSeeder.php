<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    \App\Models\User::factory()->create([
        'name' => 'Administrador',
        'email' => 'admin@tavocell.com',
        'password' => bcrypt('admin123')
    ]);

    \App\Models\User::factory(3)->create(); // Técnicos
    \App\Models\Cliente::factory(10)->create();
    \App\Models\Producto::factory(10)->create();

    \App\Models\Reparacion::factory(10)->create();
    \App\Models\SeguimientoReparacion::factory(20)->create();
}

}
