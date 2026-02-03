<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingFlowController extends Controller
{
    /**
     * หน้าเลือกวัน เวลา และอุปกรณ์/พนักงานเสริม
     */
    public function create(Studio $studio)
    {
        // โหลดข้อมูลที่จำเป็นไปให้ลูกค้าเลือก
        $studio->load(['equipments', 'staffs']);
        return view('customer.bookings.create', compact('studio'));
    }

    /**
     * บันทึกการจองและคำนวณราคา
     */
    public function store(Request $request)
    {
        $request->validate([
            'studio_id'    => 'required|exists:studios,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
            'equipment'    => 'array', // [id => quantity]
            'staff'        => 'array', // [id]
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        
        // 1. คำนวณชั่วโมงการจอง
        $hours = $this->calculateHours($request->start_time, $request->end_time);
        
        // 2. เริ่มคำนวณราคา (เริ่มต้นจากค่าเช่าสตูดิโอ)
        $totalPrice = $studio->price_per_hour * $hours;

        // ใช้ Transaction เพื่อความปลอดภัยของข้อมูล
        return DB::transaction(function () use ($request, $studio, $totalPrice) {
            
            $booking = Booking::create([
                'user_id'      => Auth::id(),
                'studio_id'    => $studio->id,
                'booking_date' => $request->booking_date,
                'start_time'   => $request->start_time,
                'end_time'     => $request->end_time,
                'total_price'  => 0, // เดี๋ยวจะ Update หลังจากบวกของเสริมเสร็จ
                'status'       => 'pending_payment',
            ]);

            // 3. รวมราคาอุปกรณ์เสริม
            if ($request->has('equipment')) {
                foreach ($request->equipment as $id => $quantity) {
                    if ($quantity > 0) {
                        $item = Equipment::find($id);
                        $itemPrice = $item->price_per_unit * $quantity;
                        $totalPrice += $itemPrice;

                        // บันทึกลงตาราง Pivot หรือ BookingItems (ถ้าคุณมี)
                        $booking->equipments()->attach($id, ['quantity' => $quantity, 'price' => $itemPrice]);
                    }
                }
            }

            // 4. รวมราคาพนักงานเสริม
            if ($request->has('staff')) {
                foreach ($request->staff as $id) {
                    $staffMember = Staff::find($id);
                    $totalPrice += $staffMember->price_per_day;
                    $booking->staffs()->attach($id, ['price' => $staffMember->price_per_day]);
                }
            }

            // 5. อัปเดตราคาสุทธิ
            $booking->update(['total_price' => $totalPrice]);

            return redirect()->route('customer.payments.show', $booking->id)
                             ->with('success', 'สร้างรายการจองแล้ว กรุณาชำระเงินภายในเวลาที่กำหนด');
        });
    }

    /**
     * Helper สำหรับคำนวณจำนวนชั่วโมง
     */
    private function calculateHours($start, $end)
    {
        $startTime = \Carbon\Carbon::parse($start);
        $endTime = \Carbon\Carbon::parse($end);
        return max(1, $startTime->diffInHours($endTime));
    }
}