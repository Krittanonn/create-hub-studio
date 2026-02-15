<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Media; // เพิ่มการเรียกใช้ Model Media
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // เพิ่มการเรียกใช้ Storage สำหรับจัดการไฟล์

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('images') // ต้องมีตัวนี้
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('provider.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('provider.studios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // ตรวจสอบไฟล์รูปภาพ
        ]);

        // 1. บันทึกข้อมูลสตูดิโอ
        $studio = Studio::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'capacity' => $request->capacity ?? 1,
            'status' => 'pending',
        ]);

        // 2. จัดการอัปโหลดรูปภาพ (ถ้ามี)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('studios', 'public');
                
                // ใช้ความสัมพันธ์ images() ตามที่คุณกำหนดใน Model
                $studio->images()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                    'is_primary' => ($index === 0), // ให้รูปแรกเป็นรูปหลักอัตโนมัติ
                ]);
            }
        }

        return redirect()->route('provider.studios.index')->with('success', 'สร้างสตูดิโอและอัปโหลดรูปภาพสำเร็จ');
    }

    public function edit(Studio $studio)
    {
        if ($studio->user_id !== Auth::id()) {
            abort(403, 'คุณไม่ใช่เจ้าของสตูดิโอนี้');
        }

        // โหลดความสัมพันธ์ images มาด้วยเพื่อป้องกัน Error ใน View
        $studio->load('images');
        
        return view('provider.studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        if ($studio->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric',
            'description' => 'required',
            'capacity' => 'nullable|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 1. อัปเดตข้อมูลทั่วไป
        $studio->update($request->only(['name', 'price_per_hour', 'description', 'capacity']));

        // 2. จัดการลบรูปภาพที่ผู้ใช้เลือก (จาก Checkbox delete_media[])
        if ($request->has('delete_media')) {
            foreach ($request->delete_media as $mediaId) {
                $media = Media::find($mediaId);
                if ($media && $media->mediable_id === $studio->id) {
                    Storage::disk('public')->delete($media->file_path); // ลบไฟล์จริง
                    $media->delete(); // ลบ Record
                }
            }
        }

        // 3. จัดการอัปโหลดรูปภาพใหม่เพิ่มเข้าไป
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('studios', 'public');
                
                $studio->images()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('provider.studios.index')->with('success', 'อัปเดตข้อมูลและรูปภาพเรียบร้อยแล้ว');
    }
}