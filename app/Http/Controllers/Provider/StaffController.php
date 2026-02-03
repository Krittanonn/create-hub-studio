<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::whereHas('studio', function($query) {
            // ✅ จุดที่ 1: เปลี่ยนจาก provider_id เป็น user_id
            $query->where('user_id', Auth::id()); 
        })->with('studio')->latest()->get();

        return view('provider.staffs.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        // Security Check
        Studio::where('id', $request->studio_id)
              // ✅ จุดที่ 2: เปลี่ยนจาก provider_id เป็น user_id
              ->where('user_id', Auth::id()) 
              ->firstOrFail();

        Staff::create($data);

        return redirect()->back()->with('success', 'เพิ่มทีมงานเรียบร้อยแล้ว');
    }

    public function destroy(Staff $staff)
    {
        // ✅ จุดที่ 3: เปลี่ยนจาก provider_id เป็น user_id
        if ($staff->studio->user_id !== Auth::id()) {
            abort(403);
        }

        $staff->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลทีมงานแล้ว');
    }
}