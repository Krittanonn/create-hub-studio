<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอุปกรณ์ - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 flex flex-col fixed">
        <div class="mb-10">
            <h2 class="text-2xl font-semibold italic text-white">CREATE<span class="text-blue-500">HUB</span></h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Provider Mode</p>
        </div>
        <nav class="space-y-2 flex-1 text-sm overflow-y-auto pr-2 custom-scrollbar">
    <div class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-2 ml-4">Main Menu</div>
    
    <a href="{{ route('provider.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-chart-pie w-5"></i> แผงควบคุม
    </a>

    <a href="{{ route('provider.studios.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.studios.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-house-laptop w-5"></i> สตูดิโอของฉัน
    </a>

    <a href="{{ route('provider.bookings.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.bookings.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-check w-5"></i> รายการจอง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Resources</div>

    <a href="{{ route('provider.equipments.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.equipments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-camera w-5"></i> อุปกรณ์เสริม
    </a>

    <a href="{{ route('provider.staffs.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.staffs.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-user-tie w-5"></i> ทีมงานพนักงาน
    </a>

    <a href="{{ route('provider.availability.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.availability.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-xmark w-5"></i> จัดการช่วงเวลาว่าง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Finance & Community</div>

    <a href="{{ route('provider.payouts.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.payouts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-wallet w-5"></i> การเงิน/ถอนเงิน
    </a>


    <a href="{{ route('provider.reviews.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.reviews.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-star w-5"></i> รีวิวจากลูกค้า
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

    <main class="flex-1 ml-64 p-10">
        <header class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-3xl font-bold text-white">อุปกรณ์ให้เช่า</h1>
                <p class="text-gray-400 mt-1">จัดการรายการอุปกรณ์เสริมสำหรับสตูดิโอของคุณ</p>
            </div>
            <a href="{{ route('provider.equipments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> เพิ่มอุปกรณ์ใหม่
            </a>
        </header>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-500 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-white/[0.02] text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-medium">ชื่ออุปกรณ์</th>
                        <th class="px-6 py-4 font-medium">สตูดิโอ</th>
                        <th class="px-6 py-4 font-medium">ราคา/หน่วย</th>
                        <th class="px-6 py-4 font-medium">คงเหลือ (Stock)</th>
                        <th class="px-6 py-4 font-medium text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($equipments as $equipment)
                    <tr class="hover:bg-white/[0.01] transition">
                        <td class="px-6 py-4 font-medium text-white">{{ $equipment->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $equipment->studio->name }}</td>
                        <td class="px-6 py-4 text-blue-400 font-bold">฿{{ number_format($equipment->price_per_unit, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded {{ $equipment->stock > 0 ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }} text-xs">
                                {{ $equipment->stock }} ชิ้น
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('provider.equipments.edit', $equipment->id) }}" class="text-gray-400 hover:text-white transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('provider.equipments.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบอุปกรณ์นี้หรือไม่?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">ยังไม่มีรายการอุปกรณ์ในระบบ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>