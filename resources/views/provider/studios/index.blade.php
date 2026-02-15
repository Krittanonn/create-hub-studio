<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสตูดิโอ - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">
    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 flex flex-col fixed">
        <div class="mb-10">
            <h2 class="text-2xl font-semibold italic">CREATE<span class="text-blue-500">HUB</span></h2>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">Provider Mode</p>
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
                <h1 class="text-3xl font-bold">สตูดิโอของฉัน</h1>
                <p class="text-gray-400 mt-1">จัดการสตูดิโอทั้งหมดที่คุณดูแลอยู่</p>
            </div>
            <a href="{{ route('provider.studios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> เพิ่มสตูดิโอใหม่
            </a>
        </header>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-500 p-4 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($studios as $studio)
            <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden flex flex-col group transition hover:border-white/10">
                <div class="h-48 bg-gray-800 relative overflow-hidden">
                    {{-- ส่วนแสดงสถานะ --}}
                    <div class="absolute top-4 right-4 z-10">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-500/20 text-green-500 border-green-500/30',
                                'pending' => 'bg-yellow-500/20 text-yellow-500 border-yellow-500/30',
                                'closed' => 'bg-red-500/20 text-red-500 border-red-500/30'
                            ];
                        @endphp
                        <span class="{{ $statusColors[$studio->status] ?? $statusColors['pending'] }} text-[10px] px-3 py-1 rounded-full font-bold uppercase border backdrop-blur-md">
                            {{ $studio->status }}
                        </span>
                    </div>

                    {{-- Logic การดึงรูปภาพ --}}
                    @php
                        // ดึงรูปที่เป็น is_primary หรือถ้าไม่มีให้เอารูปแรก
                        $cover = $studio->images->where('is_primary', true)->first() ?? $studio->images->first();
                    @endphp

                    @if($cover)
                        <img src="{{ asset('storage/' . $cover->file_path) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                             alt="{{ $studio->name }}">
                        
                        {{-- แสดงจำนวนรูปทั้งหมดที่มี --}}
                        <div class="absolute bottom-3 right-3 bg-black/50 backdrop-blur-sm text-[10px] px-2 py-1 rounded-md text-white/80">
                            <i class="fa-solid fa-images mr-1"></i> {{ $studio->images->count() }}
                        </div>
                    @else
                        {{-- Placeholder กรณีไม่มีรูป --}}
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-[#1A2238]">
                            <i class="fa-solid fa-image fa-3x mb-2"></i>
                            <span class="text-[10px] uppercase tracking-widest">No Image</span>
                        </div>
                    @endif
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold mb-2 group-hover:text-blue-400 transition">{{ $studio->name }}</h3>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ $studio->description }}</p>
                    
                    <div class="mt-auto pt-4 space-y-3 border-t border-white/5">
                        <div class="flex justify-between text-sm font-medium">
                            <span class="text-gray-500">รายชั่วโมง</span>
                            <span class="text-blue-400 font-bold">฿{{ number_format($studio->price_per_hour, 2) }}</span>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('provider.studios.edit', $studio->id) }}" class="flex-1 bg-white/5 hover:bg-white/10 py-2 rounded-lg text-xs text-center border border-white/10 transition">
                                <i class="fa-solid fa-pen mr-1"></i> แก้ไข
                            </a>
                            <form action="{{ route('provider.studios.destroy', $studio->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('ยืนยันการลบสตูดิโอนี้? ข้อมูลและรูปภาพทั้งหมดจะถูกลบถาวร')" class="px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-lg text-xs border border-red-500/20 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 bg-[#131A2E] rounded-3xl border border-dashed border-white/10 text-center">
                <i class="fa-solid fa-store-slash fa-3x text-gray-700 mb-4"></i>
                <p class="text-gray-500">คุณยังไม่มีสตูดิโอในระบบ</p>
                <a href="{{ route('provider.studios.create') }}" class="text-blue-500 hover:underline mt-2 inline-block text-sm">เริ่มสร้างสตูดิโอแรกของคุณ</a>
            </div>
            @endforelse
        </div>
    </main>
</body>
</html>