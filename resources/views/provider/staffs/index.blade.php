<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการทีมงาน - Create Hub</title>
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
        
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-white">จัดการทีมงาน (Staffs)</h1>
            <p class="text-gray-400 mt-1">เพิ่มหรือลบรายชื่อทีมงานที่พร้อมให้บริการในสตูดิโอของคุณ</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 sticky top-10">
                    <h3 class="text-lg font-semibold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-blue-500"></i> เพิ่มทีมงานใหม่
                    </h3>
                    
                    <form action="{{ route('provider.staffs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-400 mb-2">เลือกสตูดิโอ</label>
                            <select name="studio_id" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-blue-500 outline-none transition">
                                <option value="" disabled selected>เลือกสตูดิโอที่สังกัด</option>
                                @foreach(App\Models\Studio::where('user_id', auth()->id())->get() as $studio)
                                    <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">ชื่อ-นามสกุล</label>
                            <input type="text" name="name" required placeholder="เช่น นายสมชาย ช่างภาพ" 
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">ตำแหน่ง / บทบาท</label>
                            <input type="text" name="role" required placeholder="เช่น ช่างภาพ, ผู้ช่วย" 
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">ราคาต่อชั่วโมง (บาท)</label>
                            <input type="number" name="price_per_hour" required min="0" placeholder="0.00" 
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-blue-500 outline-none transition text-blue-400 font-bold">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition mt-4 shadow-lg shadow-blue-900/20">
                            บันทึกข้อมูลทีมงาน
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-white/[0.02] text-gray-400">
                            <tr>
                                <th class="px-6 py-4 font-medium">รายชื่อ</th>
                                <th class="px-6 py-4 font-medium">ตำแหน่ง</th>
                                <th class="px-6 py-4 font-medium">สตูดิโอที่สังกัด</th>
                                <th class="px-6 py-4 font-medium text-right">ค่าบริการ/ชม.</th>
                                <th class="px-6 py-4 font-medium text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($staffs as $staff)
                            <tr class="hover:bg-white/[0.01] transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 font-bold text-xs">
                                            {{ substr($staff->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-white">{{ $staff->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-400">{{ $staff->role }}</td>
                                <td class="px-6 py-4 text-gray-400">{{ $staff->studio->name }}</td>
                                <td class="px-6 py-4 text-right font-bold text-blue-400">฿{{ number_format($staff->price_per_hour, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('provider.staffs.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบข้อมูลทีมงาน?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 transition p-2">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fa-solid fa-user-slash block text-3xl mb-4 opacity-20"></i>
                                    ยังไม่มีรายชื่อทีมงานในระบบ
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>