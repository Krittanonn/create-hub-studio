<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนสตูดิโอ - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-6 md:p-10">

    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('provider.studios.index') }}" class="text-gray-500 font-bold">← ยกเลิกและกลับไป</a>
            <h1 class="text-3xl font-bold mt-2 text-gray-800">ลงทะเบียนสตูดิโอใหม่</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลให้ครบถ้วนเพื่อให้ Admin ตรวจสอบและอนุมัติ</p>
        </div>

        <form action="{{ route('provider.studios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="bg-white p-8 rounded-2xl shadow-sm space-y-4">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">ข้อมูลเบื้องต้น</h3>
                
                <div>
                    <label class="block text-sm font-bold mb-2">ชื่อสตูดิโอ *</label>
                    <input type="text" name="name" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="เช่น Studio 1 - Natural Light" required>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">ที่ตั้ง / ทำเล *</label>
                    <input type="text" name="location" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="เช่น ย่านอารีย์, กรุงเทพฯ" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">ราคาเช่าต่อชั่วโมง (บาท) *</label>
                        <input type="number" name="price_per_hour" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">ขนาดพื้นที่ (ตร.ม.)</label>
                        <input type="number" name="size" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="40">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">รายละเอียดเพิ่มเติม</label>
                    <textarea name="description" rows="4" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="อธิบายจุดเด่นของสตูดิโอคุณ..."></textarea>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">รูปภาพและสื่อ</h3>
                <div>
                    <label class="block text-sm font-bold mb-2">อัปโหลดรูปภาพหลัก (Cover Image)</label>
                    <input type="file" name="image" class="w-full border p-3 rounded-xl border-dashed border-gray-300">
                    <p class="text-[10px] text-gray-400 mt-2">แนะนำขนาด 1200x800px ไฟล์ .jpg หรือ .png</p>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-indigo-700 transition">
                ส่งข้อมูลให้ Admin อนุมัติ
            </button>
        </form>
    </div>

</body>
</html>