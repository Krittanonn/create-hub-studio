<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\User; // เพิ่ม User Model
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * สำหรับหน้า Dashboard (หน้าแรกของ Admin)
     */
    public function index()
    {
        // ดึงข้อมูลสรุปไปโชว์ใน Card ต่างๆ
        $totalUsers = User::count();
        $totalStudios = Studio::count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
        $pendingPayments = Booking::where('status', 'pending')->count();

        // ดึงรายการจองล่าสุด 5 รายการ
        $recentBookings = Booking::with(['user', 'studio'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalStudios', 
            'totalRevenue', 
            'pendingPayments', 
            'recentBookings'
        ));
    }

    /**
     * สำหรับหน้า รายงานสรุป (ที่เขียนไว้เดิม)
     */
    public function report()
    {
        // รายได้แยกตามสตูดิโอ
        $studioRevenue = Studio::withCount(['bookings' => function($query) {
            $query->where('status', 'confirmed');
        }])->get()->map(function($studio) {
            return [
                'name' => $studio->name,
                'total_bookings' => $studio->bookings_count,
                'total_money' => Booking::where('studio_id', $studio->id)
                                    ->where('status', 'confirmed')
                                    ->sum('total_price')
            ];
        });

        // รายได้รวมรายเดือน
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->select(
                DB::raw('SUM(total_price) as sum'),
                DB::raw("DATE_FORMAT(created_at, '%M') as month")
            )
            ->groupBy('month')
            ->get();

        return view('admin.reports.index', compact('studioRevenue', 'monthlyRevenue'));
    }
}