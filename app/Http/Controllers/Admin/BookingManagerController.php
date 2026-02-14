<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\Equipment;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingManagerController extends Controller
{
    /**
     * ✅ แสดงรายการการจองทั้งหมด (แก้ Error: undefined method index)
     */
    public function index()
    {
        // ดึงข้อมูลการจองพร้อม User และ Studio เพื่อลดการ Query ซ้ำ (Eager Loading)
        $bookings = Booking::with(['user', 'studio'])->latest()->paginate(15);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * ✅ อัปเดตสถานะการจอง (สอดคล้องกับ Route ใน web.php)
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'อัปเดตสถานะการจองเป็น ' . $request->status . ' เรียบร้อย');
    }

    public function create(Studio $studio)
    {
        $equipments = Equipment::where('stock', '>', 0)->get();
        $staffs = Staff::all();
        return view('bookings.create', compact('studio', 'equipments', 'staffs'));
    }

    public function store(Request $request)
    {
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

        $isBooked = Booking::where('studio_id', $studio->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->where(function($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                      ->where('end_time', '>', $start);
            })->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['error' => 'ขออภัย ช่วงเวลานี้มีการจองแล้ว']);
        }

        return DB::transaction(function () use ($request, $studio, $start, $end) {
            $hours = $start->diffInHours($end);
            $hours = $hours < 1 ? 1 : $hours;
            $studioPrice = $studio->price_per_hour * $hours;
            
            $booking = Booking::create([
                'user_id'     => Auth::id(),
                'studio_id' => $studio->id,
                'start_time' => $start,
                'end_time' => $end,
                'total_price' => $studioPrice, 
                'status' => 'pending',
            ]);

            $extraPrice = 0;

            if ($request->has('equipments')) {
                foreach ($request->equipments as $eqId => $qty) {
                    if ($qty > 0) {
                        $equipment = Equipment::find($eqId); 
                        if ($equipment) {
                            $booking->items()->create([
                                'itemable_id'   => $equipment->id,
                                'itemable_type' => Equipment::class,
                                'quantity'      => $qty,
                                'price_at_time' => $equipment->price_per_unit,
                            ]);
                            $extraPrice += ($equipment->price_per_unit * $qty);
                        }
                    }
                }
            }

            if ($request->has('staffs')) {
                foreach ($request->staffs as $staffId) {
                    $staff = Staff::find($staffId);
                    if ($staff) {
                        $booking->items()->create([
                            'itemable_id' => $staff->id,
                            'itemable_type' => Staff::class,
                            'quantity' => 1,
                            'price_at_time' => $staff->price_per_hour,
                        ]);
                        $extraPrice += ($staff->price_per_hour * $hours);
                    }
                }
            }

            $booking->update([
                'total_price' => $studioPrice + $extraPrice
            ]);

            return redirect()->route('payments.show', $booking->id)
                             ->with('success', 'จองสตูดิโอเรียบร้อย');
        });
    }

    public function show(Booking $booking)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($booking->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $booking->load(['user', 'studio', 'items.itemable', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }
}