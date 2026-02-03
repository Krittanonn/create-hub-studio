<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Studio>
 */
class StudioFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => fake()->city() . ' Studio',
            'description' => fake()->paragraph(),
            'price_per_hour' => fake()->randomElement([500, 750, 1200, 2500]),
            'capacity' => fake()->numberBetween(2, 20),
            'status' => 'active',
        ];
    }
}
