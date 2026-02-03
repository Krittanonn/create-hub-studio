<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewManagerController extends Controller
{
    public function index() {
        $reviews = Review::with(['user', 'studio'])->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review) {
        // ใช้ลบรีวิวที่ไม่เหมาะสม
        $review->delete();
        return redirect()->back()->with('success', 'ลบรีวิวเรียบร้อย');
    }
}