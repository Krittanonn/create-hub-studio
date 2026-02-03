<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('total_price', 10, 2);
            
            // สถานะการจองทั่วไป
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            
            // ✅ เพิ่มสถานะการชำระเงิน (ของลูกค้า)
            $table->string('payment_status')->default('unpaid'); // unpaid, paid

            // ✅ เพิ่มสถานะการโอนเงินให้เจ้าของสตูดิโอ (Payout)
            $table->string('payout_status')->default('unpaid'); // unpaid, requested, paid

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
