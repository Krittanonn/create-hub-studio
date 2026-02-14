<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');
        body { font-family: 'Kanit', sans-serif; }
    </style>
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 fixed flex flex-col z-50">
        <div class="mb-10 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                CH
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-wide">STUDIO<span class="text-blue-500">HUB</span></h2>
                <p class="text-[10px] text-gray-500 uppercase tracking-wider">Provider Control</p>
            </div>
        </div>

        <nav class="space-y-2 text-sm flex-1">
            <a href="{{ route('provider.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('provider.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20' : 'text-gray-400 hover:bg-white/5 transition' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> แผงควบคุม
            </a>

            <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Studio Management</div>
            
            <a href="{{ route('provider.studios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-house-laptop w-5 text-center"></i> สตูดิโอของฉัน
            </a>
            <a href="{{ route('provider.equipments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-camera w-5 text-center"></i> อุปกรณ์เสริม
            </a>
            <a href="{{ route('provider.staffs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-user-tie w-5 text-center"></i> ทีมงานพนักงาน
            </a>

            <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Operation</div>

            <a href="{{ route('provider.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i> รายการจองล่าสุด
            </a>
            <a href="{{ route('provider.availability.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-calendar-xmark w-5 text-center"></i> จัดการช่วงเวลาว่าง
            </a>

            <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold">Finance & Reviews</div>

            <a href="{{ route('provider.payouts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-wallet w-5 text-center"></i> รายได้และการถอนเงิน
            </a>
            <a href="{{ route('provider.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-star w-5 text-center"></i> รีวิวจากลูกค้า
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition group">
                    <i class="fa-solid fa-right-from-bracket group-hover:rotate-180 transition-transform duration-300"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-8 lg:p-10">
        
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold">สวัสดี, {{ auth()->user()->name }} 📸</h1>
                <p class="text-gray-400 mt-1 text-sm">นี่คือภาพรวมธุรกิจสตูดิโอของคุณในวันนี้</p>
            </div>
            <!-- <div class="flex gap-3">
                <a href="{{ route('provider.notifications.index') }}" class="w-10 h-10 rounded-full bg-[#131A2E] border border-white/10 flex items-center justify-center text-gray-400 hover:text-white transition relative">
                    <i class="fa-solid fa-bell"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-[#0B0F1A]"></span>
                </a>
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-600/20">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div> -->
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 group hover:border-blue-500/50 transition duration-300">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-2">รายได้สะสม</p>
                <h3 class="text-3xl font-bold text-blue-400">฿{{ number_format($balance ?? 0, 2) }}</h3>
                <p class="text-[10px] text-gray-500 mt-2">ยอดเงินทั้งหมดที่ยืนยันแล้ว</p>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 group hover:border-blue-500/50 transition duration-300">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-2">สตูดิโอของคุณ</p>
                <h3 class="text-3xl font-bold">{{ $totalStudios ?? 0 }}</h3>
                <p class="text-[10px] text-gray-500 mt-2">จำนวนสถานที่ลงทะเบียนไว้</p>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 group hover:border-blue-500/50 transition duration-300">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-2">รอยืนยันการจอง</p>
                <h3 class="text-3xl font-bold text-yellow-500">{{ count($pendingBookings ?? []) }}</h3>
                <p class="text-[10px] text-gray-500 mt-2">รายการจองที่รอตรวจสอบ</p>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 group hover:border-blue-500/50 transition duration-300">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-2">รีวิวล่าสุด</p>
                <h3 class="text-3xl font-bold text-green-400">4.9</h3>
                <p class="text-[10px] text-gray-500 mt-2">คะแนนเฉลี่ยจากลูกค้า</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-blue-400"></i> รายการจองล่าสุดในร้านของคุณ
                        </h3>
                        <a href="{{ route('provider.bookings.index') }}" class="text-xs text-blue-400 hover:underline">ดูทั้งหมด</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-black/20 text-gray-400 uppercase text-[10px] tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 font-medium">ลูกค้า</th>
                                    <th class="px-6 py-4 font-medium">สตูดิโอ</th>
                                    <th class="px-6 py-4 font-medium">ยอดเงิน</th>
                                    <th class="px-6 py-4 font-medium text-center">สถานะ</th>
                                    <th class="px-6 py-4 font-medium text-right">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($recentBookings as $booking)
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $booking->user->name }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $booking->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">{{ $booking->studio->name }}</td>
                                    <td class="px-6 py-4 font-bold text-blue-400">฿{{ number_format($booking->total_price, 2) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->status == 'confirmed' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20' }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('provider.bookings.show', $booking->id) }}" class="text-gray-500 hover:text-white transition p-2 rounded-lg hover:bg-white/10">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">ไม่มีรายการจองล่าสุด</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">
                    <div class="p-5 border-b border-white/5 bg-gradient-to-r from-blue-900/20 to-transparent">
                        <h3 class="font-bold text-white text-sm flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-blue-400"></i> ทางลัดจัดการร้าน
                        </h3>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-3">
                        <a href="{{ route('provider.studios.create') }}" class="p-4 bg-white/[0.02] border border-white/5 rounded-xl hover:border-blue-500/50 transition text-center group">
                            <i class="fa-solid fa-plus-circle text-2xl text-blue-500 mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[10px] text-gray-400">เพิ่มสตูดิโอ</p>
                        </a>
                        <a href="{{ route('provider.availability.index') }}" class="p-4 bg-white/[0.02] border border-white/5 rounded-xl hover:border-blue-500/50 transition text-center group">
                            <i class="fa-solid fa-clock text-2xl text-blue-500 mb-2 group-hover:scale-110 transition-transform"></i>
                            <p class="text-[10px] text-gray-400">ปิดรับจอง</p>
                        </a>
                    </div>
                </div>

                <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-6">
                    <h3 class="font-bold text-white text-sm mb-4">สถานะรายได้ล่าสุด</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500">ถอนเงินได้ทันที</span>
                            <span class="text-green-500 font-bold">฿{{ number_format($balance ?? 0, 0) }}</span>
                        </div>
                        <a href="{{ route('provider.payouts.index') }}" class="block w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-xl text-xs font-bold transition shadow-lg shadow-blue-600/20">
                            ไปหน้าถอนเงิน
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>