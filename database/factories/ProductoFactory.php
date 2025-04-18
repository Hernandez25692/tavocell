<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'nombre' => $this->faker->word(),
        'categoria' => 'Accesorios',
        'codigo' => $this->faker->unique()->numerify('PROD###'),
        'descripcion' => $this->faker->sentence(),
        'stock' => rand(5, 20),
        'precio_compra' => rand(200, 400),
        'precio_venta' => rand(450, 800),
        'proveedor' => $this->faker->company(),
    ];
}

}
