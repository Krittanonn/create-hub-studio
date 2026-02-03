<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudioAvailability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index() {
        $availabilities = StudioAvailability::with('studio')->latest()->get();
        return view('admin.availability.index', compact('availabilities'));
    }

    public function store(Request $request) {
        // ใช้สำหรับปิดวัน/เวลาที่ห้ามจอง
        StudioAvailability::create([
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'is_available' => false // บล็อกช่วงเวลานี้
        ]);
        return redirect()->back()->with('success', 'ปิดช่วงเวลาการจองเรียบร้อย');
    }
}