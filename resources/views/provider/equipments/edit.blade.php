<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขอุปกรณ์ - {{ $equipment->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 flex flex-col fixed">
        <div class="mb-10">
            <h2 class="text-2xl font-semibold italic text-white">CREATE<span class="text-blue-500">HUB</span></h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Provider Mode</p>
        </div>
        <nav class="space-y-2 flex-1 text-sm">
            <a href="{{ route('provider.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 transition">
                <i class="fa-solid fa-chart-pie"></i> แผงควบคุม
            </a>
            <a href="{{ route('provider.studios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 transition">
                <i class="fa-solid fa-house-laptop"></i> สตูดิโอของฉัน
            </a>
            <a href="{{ route('provider.equipments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white font-medium shadow-lg shadow-blue-900/20">
                <i class="fa-solid fa-toolbox"></i> จัดการอุปกรณ์
            </a>
            <a href="{{ route('provider.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 transition">
                <i class="fa-solid fa-calendar-check"></i> รายการจอง
            </a>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-10">
        
        <header class="flex items-center gap-4 mb-10">
            <a href="{{ route('provider.equipments.index') }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold">แก้ไขข้อมูลอุปกรณ์</h1>
                <p class="text-gray-400 mt-1">อัปเดตรายละเอียด ราคา และจำนวนสต็อกของอุปกรณ์</p>
            </div>
        </header>

        <div class="max-w-4xl">
            <form action="{{ route('provider.equipments.update', $equipment->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">สตูดิโอที่สังกัด</label>
                        <select name="studio_id" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition opacity-50 cursor-not-allowed" disabled>
                            @foreach($myStudios as $studio)
                                <option value="{{ $studio->id }}" {{ $equipment->studio_id == $studio->id ? 'selected' : '' }}>
                                    {{ $studio->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1">* ไม่สามารถเปลี่ยนสตูดิโอได้หลังจากสร้างแล้ว</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-2">ชื่ออุปกรณ์</label>
                            <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">ราคาเช่าต่อชิ้น (฿)</label>
                            <input type="number" step="0.01" name="price_per_unit" value="{{ old('price_per_unit', $equipment->price_per_unit) }}" required
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            @error('price_per_unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">จำนวนคงเหลือในสต็อก</label>
                            <input type="number" name="stock" value="{{ old('stock', $equipment->stock) }}" required
                                class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('provider.equipments.index') }}" class="px-6 py-3 rounded-xl text-gray-400 hover:bg-white/5 transition font-medium">
                        ยกเลิก
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition">
                        บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>