<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    /**
     * แสดงรายการรอตรวจสอบ
     */
    public function pendingPayments()
    {
        $payments = Payment::with(['booking.user', 'booking.studio'])
            ->where('status', 'pending')
            ->get();

        return view('admin.payments.verify', compact('payments'));
    }

    /**
     * อนุมัติการชำระเงิน
     */
    public function approve(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $payment->update([
                'status'  => 'completed',   // ✅ ใช้ completed
                'paid_at' => now()
            ]);

            // เปลี่ยนสถานะ booking เป็น confirmed
            $payment->booking->update([
                'status' => 'confirmed'
            ]);
        });

        return back()->with('success', 'อนุมัติยอดเงินเรียบร้อย');
    }

    /**
     * ปฏิเสธการชำระเงิน
     */
    public function reject(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $payment->update([
                'status' => 'rejected'
            ]);

            $payment->booking->update([
                'status' => 'pending'
            ]);
        });

        return back()->with('success', 'ปฏิเสธยอดเงินเรียบร้อย');
    }
}
