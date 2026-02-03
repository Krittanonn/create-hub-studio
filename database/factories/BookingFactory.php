<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        
        $start = fake()->dateTimeBetween('now', '+1 month');
        return [
            'user_id' => \App\Models\User::factory(), // สร้าง User ใหม่พ่วงไปด้วย
            'studio_id' => \App\Models\Studio::factory(), // สร้าง Studio ใหม่พ่วงไปด้วย
            'start_time' => $start,
            'end_time' => (clone $start)->modify('+'.fake()->numberBetween(2, 6).' hours'),
            'total_price' => 0, // เดี๋ยวเราค่อยไปคำนวณจริงใน Controller
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
