<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * แสดงรายการแจ้งเตือนทั้งหมดของลูกค้า
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $notifications = $user->notifications()->paginate(20);

        return view('customer.notifications.index', compact('notifications'));
    }

    /**
     * อ่านแจ้งเตือน
     */
    public function markAsRead($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        // หลังจากอ่านแล้ว อาจจะ Redirect ไปยังหน้าการจองที่เกี่ยวข้อง
        if (isset($notification->data['booking_id'])) {
            return redirect()->route('customer.bookings.show', $notification->data['booking_id']);
        }

        return redirect()->back();
    }

    /**
     * อ่านทั้งหมด
     */
    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนทั้งหมดแล้ว');
    }
}