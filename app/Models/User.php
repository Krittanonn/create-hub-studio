<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * เพิ่ม phone และ role ลงใน fillable เพื่อให้บันทึกข้อมูลได้
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',  // เพิ่ม
        'role',   // เพิ่ม
        'avatar', // เพิ่ม (ถ้ามี)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ความสัมพันธ์: User หนึ่งคนสามารถมีการจองได้หลายครั้ง
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}