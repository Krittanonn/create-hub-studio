<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index() {
        $equipments = Equipment::all();
        return view('admin.equipments.index', compact('equipments'));
    }

    public function updateStock(Request $request, Equipment $equipment) {
        $equipment->update(['stock' => $request->stock]);
        return redirect()->back()->with('success', 'อัปเดตสต็อกเรียบร้อย');
    }
}