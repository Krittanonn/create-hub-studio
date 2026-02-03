<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioController extends Controller
{
    public function index()
    {
        // ✅ เปลี่ยนจาก provider_id เป็น user_id
        $studios = Studio::where('user_id', Auth::id())->latest()->get();
        return view('provider.studios.index', compact('studios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer', // เพิ่มเผื่อไว้ให้ครบตาม Migration
        ]);

        // ✅ เปลี่ยนจาก provider_id เป็น user_id
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; // ตั้งค่าเริ่มต้นให้รอ Admin อนุมัติ

        Studio::create($data);

        return redirect()->route('provider.studios.index')->with('success', 'สร้างสตูดิโอสำเร็จ');
    }

    // เพิ่มต่อจาก index() หรือก่อน store() ก็ได้ครับ
    public function create()
    {
        // แสดงหน้าฟอร์มสำหรับสร้างสตูดิโอใหม่
        return view('provider.studios.create');
    }

    public function edit(Studio $studio)
    {
        // ✅ Security Check: เปลี่ยนจาก provider_id เป็น user_id
        if ($studio->user_id !== Auth::id()) {
            abort(403, 'คุณไม่ใช่เจ้าของสตูดิโอนี้');
        }
        return view('provider.studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        // ✅ Security Check: เปลี่ยนจาก provider_id เป็น user_id
        if ($studio->user_id !== Auth::id()) abort(403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric',
            'description' => 'required',
            'capacity' => 'nullable|integer',
        ]);

        $studio->update($data);
        return redirect()->route('provider.studios.index')->with('success', 'อัปเดตข้อมูลแล้ว');
    }
}