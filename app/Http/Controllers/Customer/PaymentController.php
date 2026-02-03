<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Booking $booking)
    {
        // Security Check: ต้องเป็นเจ้าของการจองนี้เท่านั้น
        if ($booking->user_id !== Auth::id()) abort(403);
        
        return view('customer.payments.show', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $request->validate([
            'slip_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'transfer_time' => 'required|date_format:H:i',
        ]);

        // อัปโหลดไฟล์สลิป
        $path = $request->file('slip_image')->store('payment_slips', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'slip_url' => $path,
            'amount' => $booking->total_price,
            'transfer_time' => $request->transfer_time,
            'status' => 'pending' // รอแอดมินตรวจสอบ
        ]);

        $booking->update(['status' => 'waiting_verify']);

        return redirect()->route('customer.bookings.index')->with('success', 'ส่งหลักฐานการโอนเงินแล้ว กรุณารอตรวจสอบ');
    }
}