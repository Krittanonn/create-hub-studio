<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ใช้ userId แทนเพื่อให้สื่อความหมายตรงกับ DB

        // 1. ดึงจำนวนสตูดิโอทั้งหมดที่เป็นของ Provider คนนี้
        $totalStudios = Studio::where('user_id', $userId)->count();

        // 2. ดึงรายการจองที่ "ค้างตรวจสอบ" (Pending) 
        // เฉพาะที่จองเข้ามาในสตูดิโอที่เป็นของ Provider คนนี้เท่านั้น
        $pendingBookings = Booking::whereHas('studio', function($q) use ($userId) {
            // ✅ ต้องเป็น user_id เท่านั้น เพราะในตาราง studios ไม่มี provider_id
            $q->where('user_id', $userId); 
        });

        // 3. ดึงรายการจองล่าสุด 5 รายการ (พร้อมข้อมูลลูกค้าและชื่อสตูดิโอ)
        $recentBookings = Booking::whereHas('studio', function($q) use ($userId) {
                $q->where('user_id', $userId); // เปลี่ยนจาก provider_id เป็น user_id
            })
            ->with(['user', 'studio'])
            ->latest()
            ->take(5)
            ->get();

        // 4. (แถม) คำนวณรายได้สะสมที่ถอนได้ (Balance)
        $balance = Booking::whereHas('studio', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->where('status', 'confirmed')->sum('total_price');

        return view('provider.dashboard', compact(
            'totalStudios', 
            'pendingBookings', 
            'recentBookings',
            'balance'
        ));
    }
}