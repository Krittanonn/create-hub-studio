<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    // บังคับให้ใช้ชื่อ 'staff' ตามที่เขียนใน Migration เป๊ะๆ
    protected $table = 'staffs'; 

    protected $fillable = [
        'studio_id', 
        'name', 
        'role', // ✅ เปลี่ยนจาก position เป็น role
        'price_per_hour', 
        'status'
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
}