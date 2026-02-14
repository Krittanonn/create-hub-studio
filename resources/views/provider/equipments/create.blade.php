<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มอุปกรณ์ใหม่ - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white p-10">

    <div class="max-w-2xl mx-auto">
        <header class="mb-10">
            <a href="{{ route('provider.equipments.index') }}" class="text-gray-400 hover:text-white transition text-sm flex items-center gap-2 mb-4">
                <i class="fa-solid fa-arrow-left"></i> กลับไปหน้าจัดการอุปกรณ์
            </a>
            <h1 class="text-3xl font-bold">เพิ่มอุปกรณ์ใหม่</h1>
        </header>

        <form action="{{ route('provider.equipments.store') }}" method="POST" class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm text-gray-400 mb-2">เลือกสตูดิโอที่เกี่ยวข้อง</label>
                <select name="studio_id" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition">
                    @foreach($myStudios as $studio)
                        <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                    @endforeach
                </select>
                @error('studio_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-2">ชื่ออุปกรณ์</label>
                <input type="text" name="name" required placeholder="เช่น ชุดไฟ Softbox, กล้อง Sony A7III" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">ราคาเช่าต่อหน่วย (฿)</label>
                    <input type="number" name="price_per_unit" required step="0.01" placeholder="0.00" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">จำนวนของที่มี (Stock)</label>
                    <input type="number" name="stock" required placeholder="0" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-900/20 transition mt-4">
                ยืนยันการเพิ่มอุปกรณ์
            </button>
        </form>
    </div>

</body>
</html>