<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * แสดงรายการการแจ้งเตือนทั้งหมดของ Provider
     */
    public function index()
    {
        // ใช้ตัวแปร $user และบอก Type ให้ชัดเจนในบรรทัดเดียว
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // เรียกผ่าน $user ที่ระบุ Type แล้ว
        $notifications = $user->notifications()->paginate(20);

        return view('provider.notifications.index', compact('notifications'));
    }

    /**
     * ทำเครื่องหมายว่าอ่านแล้ว (เฉพาะรายการที่เลือก)
     */
    public function markAsRead($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // เมื่อเราเรียกผ่าน $user ที่ระบุ Type ไว้ข้างบน เส้นแดงจะหายไป
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนแล้ว');
    }

    /**
     * ทำเครื่องหมายว่าอ่านแล้วทั้งหมด
     */
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนทั้งหมดเรียบร้อยแล้ว');
    }

    /**
     * ลบการแจ้งเตือน (กรณีต้องการเคลียร์หน้าจอ)
     */
    public function destroy($id)
    {
        // ใช้ Auth::user() แทน auth()->user() เพราะ Facade จะถูก IDE Helper จับได้แม่นกว่า
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user(); 

        if ($user) {
            $notification = $user->notifications()->findOrFail($id);
            $notification->delete();
        }

        return redirect()->back()->with('success', 'ลบการแจ้งเตือนแล้ว');
    }
}