<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard หลัก
     */
    public function index()
    {
        $totalUsers   = User::count();
        $totalStudios = Studio::count();

        // รายได้จริงจาก Payment
        $totalRevenue = Payment::where('status', 'completed')
            ->sum('amount');

        // จำนวนยอดรอตรวจสอบ
        $pendingPayments = Payment::where('status', 'pending')
            ->count();

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
     * Reports Page
     */
    public function report()
    {
        $year = now()->year;

        // รายได้รวม
        $totalRevenue = Payment::where('status', 'completed')
            ->sum('amount');

        // Booking แยกตามสถานะ
        $statusCounts = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // รายได้รายเดือน (จาก Payment)
        $monthlyRevenue = Payment::select(
                DB::raw('MONTH(paid_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('paid_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        // 🏆 Top Studios จาก Payment จริง
        $topStudios = Payment::select(
                'studios.id',
                'studios.name',
                DB::raw('SUM(payments.amount) as revenue')
            )
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->join('studios', 'bookings.studio_id', '=', 'studios.id')
            ->where('payments.status', 'completed')
            ->groupBy('studios.id', 'studios.name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'studio'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'statusCounts',
            'monthlyRevenue',
            'topStudios',
            'recentBookings'
        ));
    }
}
