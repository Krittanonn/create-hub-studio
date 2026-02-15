<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // --- Relations ---

    /**
     * เชื่อมต่อกับตาราง Media แบบ Polymorphic
     * เพื่อใช้เก็บรูปภาพสลิปที่ลูกค้าอัปโหลดเข้ามา
     */
    public function media()
    {
        // 'mediable' คือ prefix ของคอลัมน์ mediable_id และ mediable_type ในตาราง media
        return $this->morphMany(Media::class, 'mediable');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // --- Helpers ---

    /**
     * Helper สำหรับดึงรูปสลิปใบแรก (Primary) มาแสดงผล
     */
    public function getSlipImageAttribute()
    {
        $slip = $this->media()->where('is_primary', true)->first();
        return $slip ? $slip->file_path : null;
    }
}