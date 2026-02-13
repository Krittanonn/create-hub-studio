<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6">

        <h2 class="text-2xl font-semibold mb-10">
            <span class="text-yellow-400">ADMIN</span> PANEL
        </h2>

        <nav class="space-y-3 text-sm">

            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-3 rounded-xl bg-yellow-500 text-black font-medium">
                หน้าแรก
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                จัดการผู้ใช้งาน
            </a>

            <a href="{{ route('admin.studios.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                จัดการสตูดิโอ
            </a>

            <a href="{{ route('admin.payments.verify') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition text-yellow-400">
                ตรวจสอบยอดเงิน 🔔
            </a>

            <hr class="border-white/5 my-4">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-3 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                    ออกจากระบบ
                </button>
            </form>

        </nav>

    </aside>


    <!-- MAIN -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <header class="flex justify-between items-center mb-12">
            <h1 class="text-3xl font-semibold">
                ภาพรวมระบบ (Overview)
            </h1>

            <span class="text-gray-400 text-sm">
                ยินดีต้อนรับ, {{ auth()->user()->name }}
            </span>
        </header>


        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-sm mb-2">
                    รายได้ทั้งหมด
                </p>
                <h3 class="text-2xl font-semibold text-yellow-400">
                    ฿0.00
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-sm mb-2">
                    จำนวนผู้ใช้
                </p>
                <h3 class="text-2xl font-semibold">
                    0 คน
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-sm mb-2">
                    สตูดิโอในระบบ
                </p>
                <h3 class="text-2xl font-semibold">
                    0 แห่ง
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-yellow-400/20">
                <p class="text-gray-500 text-sm mb-2">
                    รอตรวจสลิป
                </p>
                <h3 class="text-2xl font-semibold text-yellow-400">
                    0 รายการ
                </h3>
            </div>

        </div>


        <!-- TABLE -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-6">

            <h3 class="font-semibold mb-6 text-lg">
                รายการจองล่าสุดที่เกิดขึ้น
            </h3>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead>
                        <tr class="text-gray-500 border-b border-white/5">
                            <th class="pb-4">ID</th>
                            <th class="pb-4">ลูกค้า</th>
                            <th class="pb-4">สตูดิโอ</th>
                            <th class="pb-4">ยอดเงิน</th>
                            <th class="pb-4">สถานะ</th>
                            <th class="pb-4">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6"
                                class="py-8 text-gray-500 text-center">
                                ยังไม่มีข้อมูลในระบบ
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>

    </main>

</body>

</html>