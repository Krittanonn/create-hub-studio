<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'amount' => fake()->randomFloat(2, 500, 5000),
            'payment_method' => fake()->randomElement(['transfer', 'promptpay', 'credit_card']),
            'status' => 'completed',
            'transaction_id' => Str::upper(Str::random(10)),
            'paid_at' => now(),
        ];
    }
}
