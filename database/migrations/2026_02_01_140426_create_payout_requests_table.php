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
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            
            // ✅ 1. ใครเป็นคนขอถอน (ต้องมี เพื่อให้ Error Column not found หายไป)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ✅ 2. รายละเอียดการถอน
            $table->decimal('amount', 10, 2); // ยอดเงินที่ขอถอน
            $table->string('status')->default('pending'); // pending, approved, rejected, paid
            $table->text('bank_account_details'); // ข้อมูลบัญชีธนาคาร
            $table->text('admin_note')->nullable(); // หมายเหตุจาก Admin (ถ้ามี)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
    }
};
