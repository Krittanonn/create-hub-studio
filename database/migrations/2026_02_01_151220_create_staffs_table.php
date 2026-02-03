<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('role'); // ✅ เปลี่ยนจาก position เป็น role ตรงนี้
            $table->decimal('price_per_hour', 10, 2);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }
};
