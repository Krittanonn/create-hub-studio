<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function pendingPayments() {
        // ดึงเฉพาะรายการที่รอตรวจสอบ
        $payments = Payment::with(['booking.user', 'booking.studio'])
                            ->where('status', 'pending')
                            ->get();
        return view('admin.payments.verify', compact('payments'));
    }

    public function approve(Payment $payment) {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now()
        ]);
        
        // อัปเดตสถานะการจองเป็น confirmed อัตโนมัติ
        $payment->booking->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'ยืนยันยอดเงินสำเร็จ');
    }
}