<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeguimientoReparacion>
 */
class SeguimientoReparacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'reparacion_id' => \App\Models\Reparacion::inRandomOrder()->first()->id,
        'descripcion' => $this->faker->sentence(),
        'estado' => $this->faker->randomElement(['recibido', 'en_proceso', 'listo']),
        'fecha_avance' => now(),
        'tecnico_id' => \App\Models\User::inRandomOrder()->first()->id,
        'notificado' => false,
    ];
}

}
