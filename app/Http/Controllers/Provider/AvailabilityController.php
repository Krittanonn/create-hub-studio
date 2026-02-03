<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\StudioAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ✅ เปลี่ยนจาก provider_id เป็น user_id
        $availabilities = StudioAvailability::whereHas('studio', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('studio')->latest()->get();

        // ✅ เปลี่ยนจาก provider_id เป็น user_id
        $myStudios = Studio::where('user_id', $userId)->get();

        return view('provider.availability.index', compact('availabilities', 'myStudios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'note' => 'nullable|string|max:255'
        ]);

        // ✅ Security Check: เปลี่ยนเป็น user_id
        $studio = Studio::where('id', $request->studio_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        StudioAvailability::create([
            'studio_id' => $studio->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'unavailable',
            'note' => $request->note
        ]);

        return redirect()->back()->with('success', 'บล็อกช่วงเวลาเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $userId = Auth::id();

        // ✅ ค้นหาและเช็คสิทธิ์: เปลี่ยนเป็น user_id
        $availability = StudioAvailability::whereHas('studio', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->findOrFail($id);

        $availability->delete();

        return redirect()->back()->with('success', 'เปิดให้จองช่วงเวลานี้อีกครั้งแล้ว');
    }
}