<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id',
        'date',
        'start_time',
        'end_time',
        'reason',
        'is_available'
    ];

    /**
     * เชื่อมกลับไปยัง Studio
     */
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    /**
     * Scope สำหรับเช็คเฉพาะวันที่ที่สตูดิโอ "ว่าง" 
     * (หรือใช้เช็คช่วงที่ "ปิด" ก็ได้ตาม Logic ที่คุณวางไว้)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}