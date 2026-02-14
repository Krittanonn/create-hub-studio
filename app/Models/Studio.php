<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipment;
use App\Models\Staff;


class Studio extends Model
{
    use HasFactory;
    
    // 1. เพิ่ม user_id เข้าไปเพื่อให้บันทึกข้อมูลได้
    protected $fillable = [
        'user_id', 
        'name', 
        'description', 
        'price_per_hour', 
        'capacity', 
        'status'
    ];

    // 2. ระบุความสัมพันธ์กลับไปหาเจ้าของ (User)
    // การระบุ 'user_id' ใน belongsTo จะช่วยป้องกันไม่ให้ Laravel ไปเดาเป็น provider_id
    public function user() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }


    public function bookings() { return $this->hasMany(Booking::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function availabilities() { return $this->hasMany(StudioAvailability::class); }
    
    public function images() { return $this->morphMany(Media::class, 'mediable'); }
}