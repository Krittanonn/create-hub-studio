<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index() {
        $studios = Studio::latest()->paginate(10);
        return view('admin.studios.index', compact('studios'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric',
            'capacity' => 'required|integer'
        ]);
        Studio::create($validated);
        return redirect()->back()->with('success', 'เพิ่มสตูดิโอเรียบร้อย');
    }

    public function update(Request $request, Studio $studio) {
        // อัปเดตข้อมูลตามที่ส่งมาจาก Modal
        $studio->update($request->only('status')); 
        return redirect()->back()->with('success', 'อัปเดตสถานะสตูดิโอเรียบร้อย');
    }

    public function destroy(Studio $studio) {
        $studio->delete();
        return redirect()->back()->with('success', 'ลบสตูดิโอแล้ว');
    }

}