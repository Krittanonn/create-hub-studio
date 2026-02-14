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
        $userId = Auth::id(); // ใช้ userId เพื่อเชื่อมโยงกับ user_id ในตาราง studios

        // 1. ดึงจำนวนสตูดิโอทั้งหมดที่เป็นของ Provider คนนี้
        $totalStudios = Studio::where('user_id', $userId)->count();

        // 2. ดึงรายการจองที่ "ค้างตรวจสอบ" (Pending) 
        // เติม ->get() เพื่อให้เป็น Collection ที่สามารถใช้ count() ใน Blade ได้
        $pendingBookings = Booking::whereHas('studio', function($q) use ($userId) {
            $q->where('user_id', $userId); 
        })->where('status', 'pending')->get(); 

        // 3. ดึงรายการจองล่าสุด 5 รายการ พร้อมข้อมูลลูกค้าและชื่อสตูดิโอ
        $recentBookings = Booking::whereHas('studio', function($q) use ($userId) {
                $q->where('user_id', $userId); 
            })
            ->with(['user', 'studio'])
            ->latest()
            ->take(5)
            ->get();

        // 4. คำนวณรายได้สะสมที่ถอนได้ (ยอดจากการจองที่ยืนยันแล้ว)
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