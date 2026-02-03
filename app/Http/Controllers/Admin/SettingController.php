<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index() {
        // ดึงค่า Config จากตาราง settings (ถ้ามี) หรือใช้ config file
        return view('admin.settings.index');
    }

    public function update(Request $request) {
        // อัปเดตพวกเลขบัญชีโอนเงิน หรือข้อความส่วนท้ายใบเสร็จ
        foreach ($request->except('_token') as $key => $value) {
            DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'บันทึกการตั้งค่าแล้ว');
    }
}