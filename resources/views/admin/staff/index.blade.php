<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการบุคลากร - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex">
    @include('layouts.admin-sidebar') 

    <main class="flex-1 p-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">ทีมงานและบุคลากร</h1>
            <button onclick="document.getElementById('modal-staff').classList.remove('hidden')" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                + เพิ่มพนักงาน
            </button>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left">ชื่อ-นามสกุล</th>
                        <th class="px-6 py-4 text-left">ตำแหน่ง</th>
                        <th class="px-6 py-4 text-left">ราคา/ชม.</th>
                        <th class="px-6 py-4 text-center">สถานะ</th>
                        <th class="px-6 py-4 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($staffs as $staff)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $staff->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $staff->role }}</td>
                        <td class="px-6 py-4 text-blue-600 font-bold">{{ number_format($staff->price_per_hour, 2) }} ฿</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded-full text-xs {{ $staff->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $staff->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-gray-400 hover:text-indigo-600 mr-3"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-staff" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center">
        <form action="{{ route('admin.staff.store') }}" method="POST" class="bg-white p-8 rounded-xl w-96">
            @csrf
            <h2 class="text-xl font-bold mb-4">เพิ่มข้อมูลพนักงาน</h2>
            <div class="space-y-4">
                <input type="text" name="name" placeholder="ชื่อพนักงาน" class="w-full border p-2 rounded" required>
                <select name="role" class="w-full border p-2 rounded">
                    <option value="Photographer">ช่างภาพ (Photographer)</option>
                    <option value="Assistant">ผู้ช่วย (Assistant)</option>
                    <option value="Makeup Artist">ช่างแต่งหน้า</option>
                </select>
                <input type="number" name="price_per_hour" placeholder="ราคาต่อชั่วโมง" class="w-full border p-2 rounded" required>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="this.closest('#modal-staff').classList.add('hidden')" class="px-4 py-2 border rounded">ยกเลิก</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">บันทึก</button>
            </div>
        </form>
    </div>
</body>
</html>