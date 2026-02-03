<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * แสดงรายการแจ้งเตือนทั้งหมดของ Admin
     */
    public function index()
    {
        // ดึงการแจ้งเตือนทั้งหมด (ใช้ระบบ Notification ของ Laravel)
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * กดอ่านการแจ้งเตือน (Mark as Read)
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนแล้ว');
    }

    /**
     * กดอ่านการแจ้งเตือนทั้งหมด
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนทั้งหมดเรียบร้อยแล้ว');
    }

    /**
     * ลบการแจ้งเตือนเก่าๆ
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'ลบการแจ้งเตือนแล้ว');
    }
}