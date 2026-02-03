<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest; // สมมติว่ามี Model สำหรับเก็บคำขอถอนเงิน
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayoutController extends Controller
{
    /**
     * หน้าแสดงยอดเงินที่ถอนได้และประวัติการถอนเงิน
     */
    public function index()
    {
        $user = Auth::user();
        
        // 1. คำนวณยอดเงินที่ "พร้อมถอน"
        $payoutableAmount = Booking::whereHas('studio', function($q) use ($user) {
                // ✅ จุดที่ 1: เปลี่ยนจาก provider_id เป็น user_id
                $q->where('user_id', $user->id);
            })
            ->where('status', 'confirmed')
            ->where('payout_status', 'unpaid')
            ->sum('total_price');

        // 2. ดึงประวัติการคำขอถอนเงินของ Provider คนนี้
        $payoutRequests = PayoutRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('provider.payouts.index', compact('payoutableAmount', 'payoutRequests'));
    }

    /**
     * ส่งคำขอถอนเงินไปให้ Admin
     */
    public function requestPayout(Request $request)
    {
        $user = Auth::user();

        // ตรวจสอบยอดเงินขั้นต่ำ (เช่น 500 บาท)
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'bank_account_info' => 'required|string'
        ]);

        // ตรวจสอบว่ายอดที่ขอถอน เกินยอดที่มีจริงหรือไม่
        $currentBalance = $this->calculateBalance($user->id);

        if ($request->amount > $currentBalance) {
            return redirect()->back()->withErrors(['amount' => 'ยอดเงินคงเหลือไม่เพียงพอ']);
        }

        // เริ่มบันทึกคำขอถอนเงิน
        DB::transaction(function () use ($request, $user) {
            PayoutRequest::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'status' => 'pending', // รอ Admin อนุมัติและโอนเงิน
                'bank_account_details' => $request->bank_account_info,
            ]);

            // อาจจะมีการ Mark รายการจองเหล่านั้นว่า "กำลังดำเนินการถอน" (In Progress)
        });

        return redirect()->route('provider.payouts.index')->with('success', 'ส่งคำขอถอนเงินสำเร็จแล้ว กรุณารอ Admin ดำเนินการภายใน 3-5 วันทำการ');
    }

    /**
     * Helper ฟังก์ชันสำหรับคำนวณยอดเงินคงเหลือ
     */
    private function calculateBalance($userId)
    {
        return Booking::whereHas('studio', function($q) use ($userId) {
                // ✅ จุดที่ 2: เปลี่ยนจาก provider_id เป็น user_id
                $q->where('user_id', $userId);
            })
            ->where('status', 'confirmed')
            ->where('payout_status', 'unpaid')
            ->sum('total_price');
    }
}