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
        if ($booking->user_id !== Auth::id()) abort(403);
        
        // โหลด items เพื่อไปแสดงผลหน้าบิล (ใช้ Accessor ที่เราแก้ใน Model)
        $booking->load(['studio', 'items.itemable']);
        
        return view('customer.payments.show', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $request->validate([
            'slip_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'transfer_time' => 'required',
        ]);

        // 1. สร้างรายการในตาราง payments โดยระบุ payment_method ให้ครบถ้วน
        $payment = Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $booking->total_price,
            'payment_method' => 'transfer', // ระบุค่าเพื่อให้พ้น Error "Field payment_method doesn't have a default value"
            'status'         => 'pending',
            // คุณสามารถเก็บ transfer_time ลงใน transaction_id หรือ note อื่นๆ ได้ถ้าต้องการ
            'transaction_id' => 'Time: ' . $request->transfer_time, 
        ]);

        // 2. อัปโหลดสลิปและเก็บข้อมูลในตาราง media (Morph) ตามโครงสร้างที่คุณมี
        if ($request->hasFile('slip_image')) {
            $path = $request->file('slip_image')->store('payment_slips', 'public');

            // ใช้ความสัมพันธ์ Morph บันทึกลงตาราง media
            $payment->media()->create([
                'file_path'  => $path,
                'file_type'  => 'image',
                'is_primary' => true
            ]);
        }

        // 3. อัปเดตสถานะการจอง
        $booking->update(['status' => 'waiting_verify']);

        return redirect()->route('customer.bookings.index')
                         ->with('success', 'ส่งหลักฐานการโอนเงินแล้ว กรุณารอตรวจสอบ');
    }
}