<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studio_id',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'payment_status',
        'payout_status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // --- Relations ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    /**
     * ดึงรายการ Item ทั้งหมด (ทั้ง Equipment และ Staff)
     * ผ่านตาราง booking_items ที่คุณมีอยู่แล้ว
     */
    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // --- Helpers / Accessors ---

    public function getIsPaidAttribute()
    {
        return $this->payment && $this->payment->status === 'approved';
    }

    /**
     * ดึงเฉพาะรายการอุปกรณ์เสริม (Equipment) จากตาราง booking_items
     * โดยตรวจสอบจาก itemable_type
     */
    public function getEquipmentItemsAttribute()
    {
        return $this->items->where('itemable_type', Equipment::class);
    }

    /**
     * ดึงเฉพาะรายการพนักงานเสริม (Staff) จากตาราง booking_items
     * โดยตรวจสอบจาก itemable_type
     */
    public function getStaffItemsAttribute()
    {
        return $this->items->where('itemable_type', Staff::class);
    }
}