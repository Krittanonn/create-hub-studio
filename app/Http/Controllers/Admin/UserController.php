<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * แสดงรายชื่อผู้ใช้งานทั้งหมด พร้อมระบบค้นหาและแบ่งหน้า
     */
    public function index(Request $request)
    {
        $query = User::query();

        // ระบบค้นหาด้วยชื่อหรืออีเมล
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * อัปเดตข้อมูลผู้ใช้งาน (เช่น เปลี่ยนเบอร์โทร หรือ Role)
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,customer,provider',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    /**
     * ระงับการใช้งานหรือเปิดใช้งานผู้ใช้ (Ban/Unban)
     */
    public function toggleStatus(User $user)
    {
        // สมมติว่าคุณมี column 'is_active' ในตาราง users
        // ถ้าไม่มี ให้ข้ามส่วนนี้ไปก่อน หรือเพิ่มใน Migration ครับ
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'เปิดใช้งาน' : 'ระงับการใช้งาน';
        return redirect()->back()->with('success', "เปลี่ยนสถานะผู้ใช้เป็น {$status} เรียบร้อย");
    }

    /**
     * ลบผู้ใช้งาน (กรณีจำเป็นจริงๆ)
     */
    public function destroy(User $user)
    {
        // แก้ไขบรรทัดนี้เพื่อป้องกัน IDE แจ้ง Error
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'คุณไม่สามารถลบบัญชีตัวเองได้');
        }

        $user->delete();
        return redirect()->back()->with('success', 'ลบผู้ใช้งานออกจากระบบแล้ว');
    }
}