<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * แสดงรายการพนักงานทั้งหมด
     */
    public function index()
    {
        $staffs = Staff::latest()->get();
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * บันทึกข้อมูลพนักงานใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string', // เช่น Photographer, Assistant
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        Staff::create($validated);

        return redirect()->back()->with('success', 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    /**
     * อัปเดตข้อมูลพนักงาน
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        $staff->update($validated);

        return redirect()->back()->with('success', 'อัปเดตข้อมูลพนักงานเรียบร้อย');
    }

    /**
     * ลบข้อมูลพนักงาน
     */
    public function destroy(Staff $staff)
    {
        // ตรวจสอบก่อนว่าพนักงานคนนี้ถูกผูกกับการจองที่ยังไม่เสร็จสิ้นหรือไม่ (Optional)
        $staff->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลพนักงานแล้ว');
    }
}