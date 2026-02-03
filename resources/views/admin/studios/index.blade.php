<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Manage Studios - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600">← กลับ</a>
                <h1 class="text-2xl font-bold">จัดการสตูดิโอทั้งหมด</h1>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="p-4">รูปภาพ</th>
                        <th class="p-4">ชื่อสตูดิโอ</th>
                        <th class="p-4">เจ้าของ</th>
                        <th class="p-4">สถานะ</th>
                        <th class="p-4">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($studios ?? [] as $studio)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><div class="w-16 h-10 bg-gray-200 rounded"></div></td>
                        <td class="p-4 font-bold">{{ $studio->name }}</td>
                        <td class="p-4">{{ $studio->user->name ?? 'ไม่ระบุ' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">รอการตรวจสอบ</span>
                        </td>
                        <td class="p-4 flex gap-2">
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-xs">อนุมัติ</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">ปิดชั่วคราว</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-400">ยังไม่มีสตูดิโอในระบบ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>