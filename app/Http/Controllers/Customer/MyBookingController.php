<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyBookingController extends Controller
{
    /**
     * แสดงรายการจองทั้งหมดของลูกค้า
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $bookings = $user->bookings()
            ->with('studio')
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * ดูรายละเอียดการจองรายรายการ
     */
    public function show($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ✅ แก้ไข: เปลี่ยนจาก 'equipments', 'staffs' เป็น 'items.itemable'
        // และโหลด payment.media เพื่อเอาไว้แสดงรูปสลิปในหน้าตรวจสอบด้วย
        $booking = $user->bookings()
            ->with(['studio', 'items.itemable', 'payment.media'])
            ->findOrFail($id);

        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * ยกเลิกการจอง
     */
    public function cancel($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);

        // ปรับเงื่อนไขตามสถานะที่คุณใช้จริง (เช่น 'pending')
        if ($booking->status === 'pending' || $booking->status === 'pending_payment') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'ยกเลิกการจองเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'ไม่สามารถยกเลิกรายการนี้ได้');
    }
}