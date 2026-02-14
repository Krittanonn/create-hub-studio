<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสตูดิโอ - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex">

    <aside class="w-64 bg-slate-900 text-white min-h-screen p-6 shadow-xl flex-shrink-0">
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-bold text-blue-400">Create Hub</h2>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Admin Panel</p>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-chart-pie w-5"></i>
                <span>แดชบอร์ด</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-calendar-check w-5"></i>
                <span>รายการจอง</span>
            </a>
            <a href="{{ route('admin.studios.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl bg-blue-600 shadow-lg font-bold">
                <i class="fas fa-camera-retro w-5"></i>
                <span>สตูดิโอ</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-user-shield w-5"></i>
                <span>ผู้ใช้งาน</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="pt-10">
                @csrf
                <button type="submit" class="flex items-center space-x-3 py-3 px-4 w-full rounded-xl text-red-400 hover:bg-red-600 hover:text-white transition font-bold">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>ออกจากระบบ</span>
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">จัดการสตูดิโอ</h1>
            <p class="text-gray-500 italic">ตรวจสอบและแก้ไขสถานะสตูดิโอทั้งหมดในระบบ</p>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">
                    <tr>
                        <th class="px-6 py-4">ชื่อสตูดิโอ</th>
                        <th class="px-6 py-4">เจ้าของ</th>
                        <th class="px-6 py-4 text-center">สถานะ</th>
                        <th class="px-6 py-4 text-right">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($studios as $studio)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $studio->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $studio->user->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $studio->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $studio->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button 
                                onclick="openStatusModal({{ $studio->id }}, {{ json_encode($studio->status) }})" 
                                class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <div id="statusModal" class="fixed inset-0 bg-black/60 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
            <h3 class="font-black text-gray-800 uppercase mb-4">อัปเดตสถานะ</h3>
            <form id="statusForm" action="" method="POST">
                @csrf @method('PATCH')
                <select name="status" id="statusSelect" class="w-full border-gray-200 rounded-xl mb-4">
                    <option value="active">เปิดใช้งาน (Active)</option>
                    <option value="maintenance">ปิดซ่อมบำรุง (Maintenance)</option>
                    <option value="closed">ปิดการใช้งาน (Closed)</option>
                </select>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('statusModal').classList.add('hidden')" class="flex-1 py-2 text-gray-400 font-bold">ยกเลิก</button>
                    <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-xl font-black">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(id, currentStatus) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');
            const select = document.getElementById('statusSelect');
            form.action = `/admin/studios/${id}`; 
            select.value = currentStatus;
            modal.classList.remove('hidden');
        }
    </script>
</body>
</html>