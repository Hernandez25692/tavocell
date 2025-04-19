<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReparacionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $costoTotal = $this->faker->numberBetween(300, 2000);
        $abono = $this->faker->numberBetween(0, $costoTotal); // nunca mayor al total

        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id,
            'marca' => $this->faker->randomElement(['Samsung', 'Huawei', 'Motorola', 'Xiaomi', 'iPhone']),
            'modelo' => $this->faker->word(),
            'imei' => $this->faker->optional()->numerify('###############'),
            'falla_reportada' => $this->faker->sentence(),
            'accesorios' => $this->faker->optional()->randomElement(['Cargador', 'Audífonos', 'Ninguno']),
            'tecnico_id' => User::inRandomOrder()->first()->id,
            'estado' => $this->faker->randomElement(['recibido', 'en_proceso', 'listo']),
            'fecha_ingreso' => $this->faker->date(),
            'fecha_entrega' => null,
            'costo_total' => $costoTotal,
            'abono' => $abono,
        ];
    }
}
