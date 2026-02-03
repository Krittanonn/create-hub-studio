<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;
    
    protected $fillable = ['booking_id', 'itemable_id', 'itemable_type', 'quantity', 'price_at_time'];

    // เชื่อมกลับไปยัง Booking หลัก
    public function booking() { return $this->belongsTo(Booking::class); }

    // เชื่อมไปยังต้นทาง (Equipment หรือ Staff)
    public function itemable() { return $this->morphTo(); }
}