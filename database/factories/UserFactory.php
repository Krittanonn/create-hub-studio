<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // รหัสผ่านคือ 'password'
            'remember_token' => Str::random(10),

            // --- ส่วนที่เพิ่มเข้ามาใหม่ให้ตรงกับ Migration ของเรา ---
            'phone' => fake()->phoneNumber(), // สุ่มเบอร์โทรศัพท์
            'role' => fake()->randomElement(['customer', 'provider']), // สุ่มว่าเป็นลูกค้าหรือเจ้าของสตู
            'avatar' => null, 
            'is_active' => true,
        ];
    }

    // สร้าง State พิเศษสำหรับ Admin (เผื่ออยากเรียกใช้เฉพาะทาง)
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}