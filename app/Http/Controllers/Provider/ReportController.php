<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $providerId = Auth::id(); // ชื่อตัวแปรนี้เก็บไว้ได้ครับ เพราะมันคือ ID ของเรา
        
        // 1. สรุปรายได้แยกตามเดือน
        $monthlyEarnings = Booking::whereHas('studio', function($q) use ($providerId) {
                // ✅ จุดที่ 1: เปลี่ยนเป็น user_id
                $q->where('user_id', $providerId); 
            })
            ->where('status', 'confirmed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->get();

        // 2. สรุปยอดจองแยกตามสถานะ
        $bookingStats = Booking::whereHas('studio', function($q) use ($providerId) {
                // ✅ จุดที่ 2: เปลี่ยนเป็น user_id
                $q->where('user_id', $providerId);
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('provider.reports.index', compact('monthlyEarnings', 'bookingStats'));
    }
}