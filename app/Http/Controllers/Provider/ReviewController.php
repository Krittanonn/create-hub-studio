<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * แสดงรายการรีวิวทั้งหมดของสตูดิโอที่เราเป็นเจ้าของ
     */
    public function index()
    {
        $reviews = Review::whereHas('studio', function($query) {
            // ✅ จุดที่ 1: เปลี่ยนจาก provider_id เป็น user_id
            $query->where('user_id', Auth::id());
        })->with(['user', 'studio'])->latest()->paginate(10);

        return view('provider.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review)
    {
        // ✅ จุดที่ 2: เปลี่ยนจาก provider_id เป็น user_id
        if ($review->studio->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'provider_reply' => 'required|string|max:1000'
        ]);

        $review->update([
            'provider_reply' => $request->provider_reply,
            'replied_at' => now()
        ]);

        return redirect()->back()->with('success', 'ตอบกลับรีวิวแล้ว');
    }
}