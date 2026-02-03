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

        // ดึงการจองทั้งหมดของ User นี้ พร้อมโหลดข้อมูล Studio ไปแสดงผล
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

        // ค้นหาการจองเฉพาะที่เป็นของ User นี้เท่านั้น (Security Check)
        $booking = $user->bookings()
            ->with(['studio', 'equipments', 'staffs', 'payment'])
            ->findOrFail($id);

        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * ยกเลิกการจอง (กรณีสถานะยังเป็น Pending)
     */
    public function cancel($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);

        // อนุญาตให้ยกเลิกเฉพาะรายการที่ยังไม่ได้ชำระเงิน หรือตามเงื่อนไขของคุณ
        if ($booking->status === 'pending_payment') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'ยกเลิกการจองเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'ไม่สามารถยกเลิกรายการนี้ได้ กรุณาติดต่อเจ้าหน้าที่');
    }
}