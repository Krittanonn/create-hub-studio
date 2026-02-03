<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // ต้องเป็นการจองที่สำเร็จแล้วและยังไม่เคยรีวิว
        if ($booking->status !== 'completed' || $booking->review) {
            return redirect()->back()->with('error', 'ไม่สามารถรีวิวรายการนี้ได้');
        }

        return view('customer.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'studio_id' => $booking->studio_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('customer.bookings.index')->with('success', 'ขอบคุณสำหรับรีวิวของคุณครับ!');
    }
}