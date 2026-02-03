<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\Studio;
use App\Models\Equipment;
use App\Models\Staff;
use App\Models\StudioAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class BookingManagerController extends Controller
{
    
    /**
     * หน้าแสดงฟอร์มการจอง (ถ้ามีหน้าเฉพาะ)
     */
    public function create(Studio $studio)
    {
        $equipments = Equipment::where('stock', '>', 0)->get();
        $staffs = Staff::all();
        return view('bookings.create', compact('studio', 'equipments', 'staffs'));
    }

    /**
     * ระบบบันทึกการจองและคำนวณราคา
     */
    public function store(Request $request)
    {
        
        // 1. Validation ข้อมูลพื้นฐาน
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'equipments' => 'nullable|array',
            'staffs' => 'nullable|array',
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);

        // 2. ตรวจสอบการจองซ้ำ (Double Booking Prevention)
        $isBooked = Booking::where('studio_id', $studio->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->where(function($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                      ->where('end_time', '>', $start);
            })->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['error' => 'ขออภัย ช่วงเวลานี้มีการจองแล้ว']);
        }

        // 3. เริ่มกระบวนการบันทึกข้อมูล (Database Transaction)
        return DB::transaction(function () use ($request, $studio, $start, $end) {
            
            // คำนวณค่าชั่วโมงสตูดิโอ
            $hours = $start->diffInHours($end);
            $hours = $hours < 1 ? 1 : $hours; // ขั้นต่ำ 1 ชม.
            $studioPrice = $studio->price_per_hour * $hours;
            
            // สร้าง Record การจองหลัก
            $booking = Booking::create([
                'user_id'     => Auth::id(),
                'studio_id' => $studio->id,
                'start_time' => $start,
                'end_time' => $end,
                'total_price' => $studioPrice, 
                'status' => 'pending',
            ]);

            $extraPrice = 0;

            // 4. บันทึก Add-ons: Equipments
            if ($request->has('equipments')) {
                foreach ($request->equipments as $eqId => $qty) {
                    if ($qty > 0) {
                        // ดึง Model มาก่อนเพื่อเอาข้อมูลราคาปัจจุบัน
                        $equipment = Equipment::find($eqId); 
                        
                        if ($equipment) { // กันเหนียวเผื่อหา ID ไม่เจอ
                            $booking->items()->create([
                                'itemable_id'   => $equipment->id, // เรียกจาก Model ที่ find มา
                                'itemable_type' => Equipment::class,
                                'quantity'      => $qty,
                                'price_at_time' => $equipment->price_per_unit,
                            ]);
                            $extraPrice += ($equipment->price_per_unit * $qty);
                        }
                    }
                }
            }

            // 5. บันทึก Add-ons: Staffs
            if ($request->has('staffs')) {
                foreach ($request->staffs as $staffId) {
                    $staff = Staff::find($staffId);
                    $booking->items()->create([
                        'itemable_id' => $staff->id,
                        'itemable_type' => Staff::class,
                        'quantity' => 1,
                        'price_at_time' => $staff->price_per_hour,
                    ]);
                    $extraPrice += ($staff->price_per_hour * $hours); // คิดตามจำนวนชม.ที่จอง
                }
            }

            // 6. อัปเดตราคาสุทธิ
            $booking->update([
                'total_price' => $studioPrice + $extraPrice
            ]);

            return redirect()->route('payments.show', $booking->id)
                             ->with('success', 'จองสตูดิโอเรียบร้อย กรุณาชำระเงินภายใน 30 นาที');
        });
    }

    /**
     * แสดงรายละเอียดการจองของผู้ใช้
     */
    public function show(Booking $booking)
    {
        // ใช้ Auth:: แทน auth()
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // ตอนนี้ Editor จะรู้แล้วว่า $user คือ Model User ทำให้เรียก id และ role ได้ไม่แดง
        if ($booking->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $booking->load(['studio', 'items.itemable', 'payment']);
        return view('bookings.show', compact('booking'));
    }
}