<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ✅ แก้จาก provider_id เป็น user_id
        $equipments = Equipment::whereHas('studio', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('studio')->latest()->get();

        return view('provider.equipments.index', compact('equipments'));
    }

    public function create()
    {
        // ✅ แก้จาก provider_id เป็น user_id
        $myStudios = Studio::where('user_id', Auth::id())->get();
        return view('provider.equipments.create', compact('myStudios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_unit' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // ✅ Security Check: แก้เป็น user_id
        $studio = Studio::where('id', $request->studio_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        Equipment::create($data);

        return redirect()->route('provider.equipments.index')
                         ->with('success', 'เพิ่มอุปกรณ์เรียบร้อยแล้ว');
    }

    public function edit(Equipment $equipment)
    {
        // ✅ ตรวจสอบสิทธิ์ผ่าน Relationship: แก้เป็น user_id
        if ($equipment->studio->user_id !== Auth::id()) {
            abort(403);
        }

        $myStudios = Studio::where('user_id', Auth::id())->get();
        return view('provider.equipments.edit', compact('equipment', 'myStudios'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        // ✅ แก้เป็น user_id
        if ($equipment->studio->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_unit' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 'status' => 'required|in:available,unavailable,broken', // ปิดไว้ก่อนถ้าใน DB ยังไม่มีคอลัมน์ status
        ]);

        $equipment->update($data);

        return redirect()->route('provider.equipments.index')
                         ->with('success', 'อัปเดตข้อมูลอุปกรณ์แล้ว');
    }

    public function destroy(Equipment $equipment)
    {
        // ✅ แก้เป็น user_id
        if ($equipment->studio->user_id !== Auth::id()) {
            abort(403);
        }

        $equipment->delete();

        return redirect()->route('provider.equipments.index')
                         ->with('success', 'ลบอุปกรณ์ออกจากระบบแล้ว');
    }
}