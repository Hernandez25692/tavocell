<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reparacion>
 */
class ReparacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'cliente_id' => \App\Models\Cliente::inRandomOrder()->first()->id,
        'marca' => $this->faker->randomElement(['Samsung', 'Huawei', 'Xiaomi', 'iPhone']),
        'modelo' => 'Modelo ' . $this->faker->randomDigit(),
        'imei' => $this->faker->numerify('###############'),
        'falla_reportada' => $this->faker->sentence(),
        'accesorios' => $this->faker->randomElement(['Sin accesorios', 'Cargador', 'Audífonos', 'Cargador y estuche']),
        'tecnico_id' => \App\Models\User::inRandomOrder()->first()->id,
        'estado' => $this->faker->randomElement(['recibido', 'en_proceso', 'listo']),
        'fecha_ingreso' => now()->subDays(rand(1, 10)),
        'total' => rand(500, 1200),
    ];
}

}
