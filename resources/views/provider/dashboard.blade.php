<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white flex min-h-screen font-sans">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F1525] border-r border-white/5 hidden md:flex flex-col">

        <div class="p-6 text-xl font-semibold border-b border-white/5 text-center">
            <span class="text-yellow-400">CREATE</span> HUB
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="{{ route('provider.dashboard') }}"
                class="block px-4 py-3 rounded-xl bg-yellow-500 text-black font-medium">
                📊 Dashboard
            </a>

            <a href="{{ route('provider.bookings.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                📅 รายการจอง
            </a>

            <a href="{{ route('provider.studios.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                🏠 สตูดิโอของฉัน
            </a>

            <a href="{{ route('provider.equipments.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                💡 อุปกรณ์เช่า
            </a>

            <a href="{{ route('provider.staffs.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                👨‍💼 ทีมงาน
            </a>

            <a href="{{ route('provider.payouts.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                💰 การเงิน
            </a>

        </nav>

        <div class="p-4 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full px-4 py-3 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                    🚪 ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>


    <!-- MAIN -->
    <main class="flex-1 p-10 space-y-10">

        <h2 class="text-2xl font-semibold">
            Welcome back, {{ auth()->user()->name }} 👋
        </h2>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-400 text-xs uppercase mb-2">ยอดเงินคงเหลือ</p>
                <h3 class="text-3xl font-bold text-yellow-400">
                    ฿{{ number_format($balance ?? 0, 2) }}
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-400 text-xs uppercase mb-2">จำนวนสตูดิโอ</p>
                <h3 class="text-3xl font-bold">
                    {{ $totalStudios ?? 0 }}
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-400 text-xs uppercase mb-2">รายการจองเดือนนี้</p>
                <h3 class="text-3xl font-bold text-green-400">
                    {{ $monthlyBookings ?? 0 }}
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-400 text-xs uppercase mb-2">รีวิวเฉลี่ย</p>
                <h3 class="text-3xl font-bold text-yellow-400">
                    4.9
                </h3>
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

            <div class="p-6 border-b border-white/5 flex justify-between">
                <h3 class="font-semibold">รายการจองล่าสุด</h3>
                <a href="{{ route('provider.bookings.index') }}"
                    class="text-yellow-400 text-sm hover:underline">
                    ดูทั้งหมด
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-gray-400 border-b border-white/5">
                        <tr>
                            <th class="p-4">สตูดิโอ</th>
                            <th class="p-4">วันที่</th>
                            <th class="p-4">ลูกค้า</th>
                            <th class="p-4">ยอดเงิน</th>
                            <th class="p-4">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings ?? [] as $booking)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="p-4 font-medium">
                                {{ $booking->studio->name }}
                            </td>
                            <td class="p-4 text-gray-400">
                                {{ $booking->start_time->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 text-gray-400">
                                {{ $booking->user->name }}
                            </td>
                            <td class="p-4 text-yellow-400 font-semibold">
                                ฿{{ number_format($booking->total_price) }}
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-500">
                                ยังไม่มีรายการจอง
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>

</html>