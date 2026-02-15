<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Staff;
use App\Models\BookingItem; // เรียกใช้ Model Item
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingFlowController extends Controller
{
    public function create(Studio $studio)
    {
        $studio->load(['equipments', 'staffs']);
        return view('customer.bookings.create', compact('studio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_id'    => 'required|exists:studios,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
            'equipment'    => 'array',
            'staff'        => 'array',
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        $hours = $this->calculateHours($request->start_time, $request->end_time);
        
        // ราคาตั้งต้นจากค่าเช่าสตู
        $baseStudioPrice = $studio->price_per_hour * $hours;

        return DB::transaction(function () use ($request, $studio, $baseStudioPrice) {
            
            // 1. สร้างหัวข้อการจอง (ระวัง: หาก DB ไม่มีคอลัมน์ booking_date ให้ใช้ start_time แบบเต็ม)
            $booking = Booking::create([
                'user_id'      => Auth::id(),
                'studio_id'    => $studio->id,
                'start_time'   => $request->booking_date . ' ' . $request->start_time,
                'end_time'     => $request->booking_date . ' ' . $request->end_time,
                'total_price'  => $baseStudioPrice, 
                'status'       => 'pending', // ตาม default ใน migration
            ]);

            $extraPrice = 0;

            // 2. จัดการอุปกรณ์เสริม (บันทึกลง booking_items)
            if ($request->has('equipment')) {
                foreach ($request->equipment as $id => $quantity) {
                    if ($quantity > 0) {
                        $item = Equipment::find($id);
                        if ($item) {
                            $itemTotalPrice = $item->price_per_unit * $quantity;
                            $extraPrice += $itemTotalPrice;

                            // ใช้ความสามารถของ Polymorphic ในการบันทึก
                            $booking->items()->create([
                                'itemable_id'   => $item->id,
                                'itemable_type' => Equipment::class, // จะบันทึกเป็น 'App\Models\Equipment'
                                'quantity'      => $quantity,
                                'price_at_time' => $item->price_per_unit,
                            ]);
                        }
                    }
                }
            }

            // 3. จัดการพนักงานเสริม (บันทึกลง booking_items)
            if ($request->has('staff')) {
                foreach ($request->staff as $id) {
                    $staffMember = Staff::find($id);
                    if ($staffMember) {
                        // เช็คชื่อคอลัมน์: ใน migration staffs ของคุณคือ price_per_hour
                        $staffPrice = $staffMember->price_per_hour; 
                        $extraPrice += $staffPrice;

                        $booking->items()->create([
                            'itemable_id'   => $staffMember->id,
                            'itemable_type' => Staff::class, // จะบันทึกเป็น 'App\Models\Staff'
                            'quantity'      => 1,
                            'price_at_time' => $staffPrice,
                        ]);
                    }
                }
            }

            // 4. อัปเดตราคารวมสุดท้าย
            $booking->update([
                'total_price' => $baseStudioPrice + $extraPrice
            ]);

            return redirect()->route('customer.payments.show', $booking->id)
                             ->with('success', 'สร้างรายการจองแล้ว');
        });
    }

    private function calculateHours($start, $end)
    {
        $startTime = \Carbon\Carbon::parse($start);
        $endTime = \Carbon\Carbon::parse($end);
        return max(1, $startTime->diffInHours($endTime));
    }
}