<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingItem>
 */
class BookingItemFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        // สุ่มว่าจะให้เป็น Equipment หรือ Staff
        $itemable = fake()->randomElement([
            \App\Models\Equipment::class,
            \App\Models\Staff::class,
        ]);

        return [
            'booking_id' => \App\Models\Booking::factory(),
            'itemable_id' => $itemable::factory(),
            'itemable_type' => $itemable,
            'quantity' => fake()->numberBetween(1, 2),
            'price_at_time' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}
