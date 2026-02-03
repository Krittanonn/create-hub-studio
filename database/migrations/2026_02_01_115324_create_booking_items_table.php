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
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->morphs('itemable'); // จะสร้าง itemable_id และ itemable_type
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_time', 10, 2); // บันทึกราคา ณ วันที่จอง (กันราคาเปลี่ยนภายหลัง)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};
