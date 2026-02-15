<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ค้นหาสตูดิโอ | Create Hub Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-14">

    {{-- ส่วนหัวของหน้า --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-white">Explore <span class="text-blue-500">Studios</span></h1>
            <p class="text-blue-300/60 mt-2 text-sm uppercase tracking-widest font-medium">ค้นหาพื้นที่สร้างสรรค์ผลงานของคุณ</p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('customer.bookings.index') }}" class="text-blue-400 hover:text-blue-300 transition text-sm font-semibold">การจองของฉัน</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 border border-red-500/20 shadow-lg shadow-red-900/10">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>ออกจากระบบ
                </button>
            </form>
        </div>
    </div>

    {{-- ฟอร์มค้นหา --}}
    <form method="GET" action="{{ route('customer.explore.index') }}" 
          class="bg-[#111C33]/80 backdrop-blur-xl p-6 rounded-3xl border border-blue-900/30 shadow-2xl mb-12 grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-4 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-blue-500/50"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ชื่อสตูดิโอ..." 
                   class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl pl-12 pr-4 py-3 text-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
        </div>
        <div class="md:col-span-3">
            <select name="type" class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-4 py-3 text-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all appearance-none">
                <option value="">ทุกประเภท</option>
                <option value="music" {{ request('type') == 'music' ? 'selected' : '' }}>Music Studio</option>
                <option value="photography" {{ request('type') == 'photography' ? 'selected' : '' }}>Photography</option>
                <option value="dance" {{ request('type') == 'dance' ? 'selected' : '' }}>Dance & Acting</option>
            </select>
        </div>
        <div class="md:col-span-3 flex gap-2">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-1/2 bg-[#07101F] border border-blue-900/40 rounded-2xl px-4 py-3 text-blue-100 focus:outline-none">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-1/2 bg-[#07101F] border border-blue-900/40 rounded-2xl px-4 py-3 text-blue-100 focus:outline-none">
        </div>
        <div class="md:col-span-2">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-2xl transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                ค้นหา
            </button>
        </div>
    </form>

    {{-- ส่วนแสดงรายการสตูดิโอ --}}
    @if($studios->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($studios as $studio)
                <div class="group bg-[#111C33]/50 rounded-[2rem] border border-blue-900/30 overflow-hidden hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-2 shadow-xl">
                    <div class="relative h-56 bg-[#0F1A2F] overflow-hidden">
                        {{-- ดึงรูปภาพจากความสัมพันธ์ images ที่กำหนดใน Model Studio --}}
                        @php
                            $cover = $studio->images->where('is_primary', true)->first() ?? $studio->images->first();
                        @endphp

                        @if($cover)
                            <img src="{{ asset('storage/' . $cover->file_path) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                 alt="{{ $studio->name }}">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-blue-500/20 group-hover:scale-110 transition-transform duration-700">
                                <i class="fa-solid fa-camera-retro text-5xl mb-2"></i>
                                <span class="text-[10px] uppercase tracking-widest font-bold">No Image</span>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4 bg-blue-600/90 backdrop-blur-md text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full">
                            {{ $studio->status }}
                        </div>
                    </div>

                    <div class="p-8">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $studio->name }}</h3>
                        <p class="text-blue-300/50 text-xs flex items-center mb-6">
                            <i class="fa-solid fa-users mr-2"></i> รองรับ {{ $studio->capacity }} คน
                        </p>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-blue-300/40 uppercase font-bold tracking-tighter">ราคาเช่า</p>
                                <p class="text-2xl font-black text-blue-400">฿{{ number_format($studio->price_per_hour) }}<span class="text-xs font-normal text-blue-300/60">/ชม.</span></p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('customer.explore.show', $studio->id) }}" class="p-3 rounded-xl bg-blue-900/30 text-blue-400 hover:bg-blue-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('customer.bookings.create', $studio->id) }}" class="px-5 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-500 shadow-lg shadow-blue-600/20 transition-all">
                                    จองเลย
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $studios->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-32 bg-[#111C33]/30 rounded-[3rem] border border-dashed border-blue-900/40">
            <i class="fa-solid fa-ghost text-5xl text-blue-900 mb-4"></i>
            <p class="text-blue-300/50 text-xl font-medium italic">ไม่พบสตูดิโอที่คุณกำลังมองหา</p>
            <a href="{{ route('customer.explore.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">แสดงทั้งหมด</a>
        </div>
    @endif

</div>
</body>
</html>