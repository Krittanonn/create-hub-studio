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
        $studio->update($request->all());
        return redirect()->back()->with('success', 'อัปเดตข้อมูลแล้ว');
    }

    public function destroy(Studio $studio) {
        $studio->delete();
        return redirect()->back()->with('success', 'ลบสตูดิโอแล้ว');
    }
}