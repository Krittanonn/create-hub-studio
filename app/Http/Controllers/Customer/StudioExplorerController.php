<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioExplorerController extends Controller
{
    public function index(Request $request)
    {
        $query = Studio::query()->where('status', 'active');

        // กรองตามคำค้นหา (ชื่อสตู)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // กรองตามประเภท
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // กรองตามราคา (Min-Max)
        if ($request->filled('min_price')) {
            $query->where('price_per_hour', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        $studios = $query->latest()->paginate(12);
        return view('customer.explore.index', compact('studios'));
    }

    public function show(Studio $studio)
    {
        // โหลดข้อมูลพนักงาน อุปกรณ์ และรีวิวมาแสดงในหน้าเดียว
        $studio->load(['equipments', 'staffs', 'reviews.user']);
        return view('customer.explore.show', compact('studio'));
    }
}