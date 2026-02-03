<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // ✅ เปลี่ยนจาก provider_id เป็น user_id
        $bookings = Booking::whereHas('studio', function($query) {
            $query->where('user_id', Auth::id()); 
        })->with(['user', 'studio'])->latest()->paginate(10);

        return view('provider.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // ✅ เปลี่ยนจาก provider_id เป็น user_id 
        // เพื่อเช็คว่าเจ้าของสตูดิโอคือคนที่ Login อยู่จริงหรือไม่
        if ($booking->studio->user_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลการจองนี้');
        }
        
        return view('provider.bookings.show', compact('booking'));
    }

}