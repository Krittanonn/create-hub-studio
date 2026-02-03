<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => fake()->randomElement(['Softbox Godox', 'Tripod Manfrotto', 'Wireless Mic Rode', 'Canon R5']),
            'price_per_unit' => fake()->randomElement([150, 300, 500, 1000]),
            'stock' => fake()->numberBetween(1, 10),
        ];
    }
}
