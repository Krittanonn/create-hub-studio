<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    // 1. เพิ่ม studio_id เข้าไปเพื่อให้บันทึกความเชื่อมโยงกับสตูดิโอได้
    protected $fillable = ['studio_id', 'name', 'price_per_unit', 'stock'];

    // 2. เพิ่มฟังก์ชัน studio() เพื่อเชื่อมความสัมพันธ์ (Relationship)
    public function studio() 
    { 
        return $this->belongsTo(Studio::class, 'studio_id'); 
    }
    
    public function bookingItems() { return $this->morphMany(BookingItem::class, 'itemable'); }
}