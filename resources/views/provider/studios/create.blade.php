<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสตูดิโอใหม่ - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white p-10">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('provider.studios.index') }}" class="text-gray-500 hover:text-white mb-6 inline-block transition">← กลับหน้าจัดการ</a>
        
        <div class="bg-[#131A2E] rounded-3xl border border-white/5 p-8">
            <h1 class="text-3xl font-bold mb-2">เพิ่มสตูดิโอใหม่</h1>
            <p class="text-gray-400 mb-10 text-sm">ระบุข้อมูลสตูดิโอของคุณ (สถานะเริ่มต้นจะเป็น Pending เพื่อรอ Admin อนุมัติ)</p>

            <form action="{{ route('provider.studios.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm text-gray-400">ชื่อสตูดิโอ <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-gray-400">ราคาต่อชั่วโมง (บาท) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_per_hour" step="0.01" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">ความจุ (คน)</label>
                    <input type="number" name="capacity" value="1" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">รายละเอียดสตูดิโอ <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition" placeholder="ระบุรายละเอียด เช่น อุปกรณ์ที่มี กฎการใช้ห้อง หรือสถานที่ตั้ง..."></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                    บันทึกข้อมูลและส่งตรวจสอบ
                </button>
            </form>
        </div>
    </div>
</body>
</html>