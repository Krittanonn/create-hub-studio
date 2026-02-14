<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไข: {{ $studio->name }} - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0B0F1A] text-white p-10">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('provider.studios.index') }}" class="text-gray-500 hover:text-white mb-6 inline-block transition">← ยกเลิก</a>
        
        <div class="bg-[#131A2E] rounded-3xl border border-white/5 p-8">
            <h1 class="text-2xl font-bold mb-8">แก้ไขข้อมูลสตูดิโอ</h1>

            <form action="{{ route('provider.studios.update', $studio->id) }}" method="POST" class="space-y-6">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm text-gray-400">ชื่อสตูดิโอ</label>
                        <input type="text" name="name" value="{{ $studio->name }}" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-gray-400">ราคาต่อชั่วโมง (บาท)</label>
                        <input type="number" name="price_per_hour" value="{{ $studio->price_per_hour }}" step="0.01" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">ความจุ (คน)</label>
                    <input type="number" name="capacity" value="{{ $studio->capacity }}" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">รายละเอียด</label>
                    <textarea name="description" rows="5" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">{{ $studio->description }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-xl font-bold transition">
                    อัปเดตข้อมูลสตูดิโอ
                </button>
            </form>
        </div>
    </div>
</body>
</html>