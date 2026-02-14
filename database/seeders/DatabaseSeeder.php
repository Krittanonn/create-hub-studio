<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Studio;
use App\Models\Equipment;
use App\Models\Staff;
use App\Models\StudioAvailability;
use App\Models\Media;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Models\Review;
use App\Models\PayoutRequest;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        $provider = User::create([
            'name' => 'Provider User',
            'email' => 'provider@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'provider',
        ]);

        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | STUDIOS (5)
        |--------------------------------------------------------------------------
        */

        $studios = collect([
            ['Studio A', 500],
            ['Studio B', 600],
            ['Studio C', 700],
            ['Studio D', 800],
            ['Studio E', 900],
        ])->map(function ($data) use ($provider) {
            return Studio::create([
                'name' => $data[0],
                'user_id' => $provider->id,
                'price_per_hour' => $data[1],
                'capacity' => 5,
                'status' => 'active',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | EQUIPMENTS
        |--------------------------------------------------------------------------
        */

        $equipments = [];

        foreach ($studios as $studio) {
            $equipments[] = Equipment::create([
                'studio_id' => $studio->id,
                'name' => 'Camera',
                'price_per_unit' => 300,
                'stock' => 10,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | STAFFS
        |--------------------------------------------------------------------------
        */

        foreach ($studios as $studio) {
            Staff::create([
                'studio_id' => $studio->id,
                'name' => 'Trainer ' . $studio->id,
                'role' => 'trainer',
                'price_per_hour' => 500,
                'status' => 'active',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDIO AVAILABILITY
        |--------------------------------------------------------------------------
        */

        foreach ($studios as $studio) {
            StudioAvailability::create([
                'studio_id' => $studio->id,
                'date' => now()->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'is_available' => 1,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | MEDIA
        |--------------------------------------------------------------------------
        */

        foreach ($studios as $studio) {
            Media::create([
                'mediable_id' => $studio->id,
                'mediable_type' => Studio::class,
                'file_path' => 'studios/sample.jpg',
                'file_type' => 'image',
                'is_primary' => 1,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BOOKINGS + ITEMS + PAYMENTS
        |--------------------------------------------------------------------------
        */

        foreach ($studios as $index => $studio) {

            $start = Carbon::now()->addDays($index);
            $end = (clone $start)->addHours(2);

            $booking = Booking::create([
                'user_id' => $customer->id,
                'studio_id' => $studio->id,
                'start_time' => $start,
                'end_time' => $end,
                'total_price' => 1000,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payout_status' => 'unpaid',
            ]);

            BookingItem::create([
                'booking_id' => $booking->id,
                'itemable_id' => $equipments[$index]->id,
                'itemable_type' => Equipment::class,
                'quantity' => 1,
                'price_at_time' => 300,
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => 1000,
                'payment_method' => 'credit_card',
                'status' => 'paid',
                'transaction_id' => Str::uuid(),
                'paid_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | REVIEWS
        |--------------------------------------------------------------------------
        */

        foreach ($studios as $studio) {
            Review::create([
                'user_id' => $customer->id,
                'studio_id' => $studio->id,
                'rating' => rand(3,5),
                'comment' => 'Great studio!',
                'created_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAYOUT REQUESTS
        |--------------------------------------------------------------------------
        */

        PayoutRequest::create([
            'user_id' => $provider->id,
            'amount' => 3000,
            'status' => 'pending',
            'bank_account_details' => 'Bank: KBank | 123-456-7890',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PASSWORD RESET TOKENS
        |--------------------------------------------------------------------------
        */


    }
}
