<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <aside class="w-64 bg-slate-900 min-h-screen text-white p-6">
        <h2 class="text-2xl font-bold mb-8 text-blue-400">Admin Panel</h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block p-2 bg-blue-600 rounded">หน้าแรก</a>
            <a href="{{ route('admin.users.index') }}" class="block p-2 hover:bg-slate-800 rounded">จัดการผู้ใช้งาน</a>
            <a href="{{ route('admin.studios.index') }}" class="block p-2 hover:bg-slate-800 rounded">จัดการสตูดิโอ</a>
            <a href="{{ route('admin.payments.verify') }}" class="block p-2 hover:bg-slate-800 rounded text-yellow-400">ตรวจสอบยอดเงิน 🔔</a>
            <hr class="border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left p-2 text-red-400 hover:bg-red-900/20 rounded">ออกจากระบบ</button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">ภาพรวมระบบ (Overview)</h1>
            <span class="text-gray-500">ยินดีต้อนรับ, {{ auth()->user()->name }}</span>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-gray-500 text-sm">รายได้ทั้งหมด</p>
                <h3 class="text-2xl font-bold text-green-600">฿0.00</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-gray-500 text-sm">จำนวนผู้ใช้</p>
                <h3 class="text-2xl font-bold">0 คน</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-gray-500 text-sm">สตูดิโอในระบบ</p>
                <h3 class="text-2xl font-bold">0 แห่ง</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-yellow-200">
                <p class="text-gray-500 text-sm">รอตรวจสลิป</p>
                <h3 class="text-2xl font-bold text-yellow-600">0 รายการ</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="font-bold mb-4 text-lg">รายการจองล่าสุดที่เกิดขึ้น</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 border-b text-sm">
                            <th class="pb-3">ID</th>
                            <th class="pb-3">ลูกค้า</th>
                            <th class="pb-3">สตูดิโอ</th>
                            <th class="pb-3">ยอดเงิน</th>
                            <th class="pb-3">สถานะ</th>
                            <th class="pb-3">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr>
                            <td class="py-4 text-gray-400" colspan="6 text-center">ยังไม่มีข้อมูลในระบบ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>