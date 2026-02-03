<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        // 1. สร้าง Admin & Provider (ส่วนเดิมของคุณ ดีอยู่แล้ว)
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $provider = User::factory()->create([
            'name' => 'Test Provider',
            'email' => 'provider@test.com',
            'password' => bcrypt('password'),
            'role' => 'provider',
        ]);

        // 2. สร้าง Studios (แก้จุดนี้: ส่ง user_id ของ provider เข้าไปด้วย)
        $studios = \App\Models\Studio::factory(5)->create([
            'user_id' => $provider->id, // ✅ ระบุเจ้าของให้ชัดเจน
        ]);

        // 3. สร้าง Equipment & Staff (ต้องผูกกับ Studio ด้วย)
        foreach ($studios as $studio) {
            \App\Models\Equipment::factory(3)->create([
                'studio_id' => $studio->id // ✅ ผูกอุปกรณ์เข้ากับสตูฯ
            ]);
            
            \App\Models\Staff::factory(2)->create([
                'studio_id' => $studio->id // ✅ ผูกพนักงานเข้ากับสตูฯ
            ]);

            // สร้าง Media & Availability (ส่วนเดิมของคุณ)
            \App\Models\Media::factory()->create([
                'mediable_id' => $studio->id,
                'mediable_type' => \App\Models\Studio::class,
                'is_primary' => true,
            ]);
            
            \App\Models\StudioAvailability::factory(3)->create([
                'studio_id' => $studio->id
            ]);
        }

        // 4. สร้างลูกค้าและการจอง (ส่วนเดิมของคุณ)
        $customers = User::factory(5)->create(['role' => 'customer']);
        $equipments = \App\Models\Equipment::all();

        foreach ($customers as $customer) {
            $targetStudio = $studios->random();
            $booking = \App\Models\Booking::factory()->create([
                'user_id' => $customer->id,
                'studio_id' => $targetStudio->id,
            ]);

            \App\Models\BookingItem::factory()->create([
                'booking_id' => $booking->id,
                'itemable_id' => $equipments->where('studio_id', $targetStudio->id)->random()->id,
                'itemable_type' => \App\Models\Equipment::class,
            ]);

            \App\Models\Payment::factory()->create([
                'booking_id' => $booking->id,
            ]);

            \App\Models\Review::factory()->create([
                'user_id' => $customer->id,
                'studio_id' => $booking->studio_id,
            ]);
        }
    }
}
