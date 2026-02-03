<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'mediable_id' => \App\Models\Studio::factory(),
            'mediable_type' => \App\Models\Studio::class,
            'file_path' => 'uploads/studios/' . fake()->word() . '.jpg',
            'file_type' => 'image',
            'is_primary' => fake()->boolean(20), // 20% Chance ให้เป็นรูปหลัก
        ];
    }
}
