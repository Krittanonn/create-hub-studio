<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสตูดิโอ - {{ $studio->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-6 md:p-10">

    <div class="max-w-3xl mx-auto">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <a href="{{ route('provider.studios.index') }}" class="text-indigo-600 font-bold text-sm">← กลับไปรายการสตูดิโอ</a>
                <h1 class="text-3xl font-bold mt-2 text-gray-800">แก้ไขข้อมูลสตูดิโอ</h1>
                <p class="text-gray-500 italic">สตูดิโอ: {{ $studio->name }}</p>
            </div>
            @if($studio->status == 'active')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold mb-2">ออนไลน์อยู่</span>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-6 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('provider.studios.update', $studio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH') {{-- สำคัญมาก: Laravel ใช้ PATCH สำหรับการแก้ไขข้อมูล --}}
            
            <div class="bg-white p-8 rounded-2xl shadow-sm space-y-4">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">ข้อมูลที่ต้องการปรับปรุง</h3>
                
                <div>
                    <label class="block text-sm font-bold mb-2">ชื่อสตูดิโอ</label>
                    <input type="text" name="name" value="{{ old('name', $studio->name) }}" 
                           class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">ที่ตั้ง / ทำเล</label>
                    <input type="text" name="location" value="{{ old('location', $studio->location) }}" 
                           class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">ราคาเช่าต่อชั่วโมง (บาท)</label>
                        <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $studio->price_per_hour) }}" 
                               class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">ขนาดพื้นที่ (ตร.ม.)</label>
                        <input type="number" name="size" value="{{ old('size', $studio->size) }}" 
                               class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">รายละเอียดเพิ่มเติม</label>
                    <textarea name="description" rows="4" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description', $studio->description) }}</textarea>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">รูปภาพสตูดิโอ</h3>
                
                <div class="mb-4">
                    <p class="text-xs text-gray-400 mb-2 font-bold uppercase">รูปภาพปัจจุบัน:</p>
                    <div class="w-48 h-32 bg-gray-200 rounded-lg overflow-hidden border">
                        {{-- ตรวจสอบว่ามีรูปไหม ถ้าไม่มีให้โชว์ Placeholder --}}
                        <img src="{{ $studio->image_url ?? 'https://via.placeholder.com/400x300?text=No+Image' }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">เปลี่ยนรูปภาพใหม่ (ถ้ามี)</label>
                    <input type="file" name="image" class="w-full border p-3 rounded-xl border-dashed border-gray-300">
                    <p class="text-[10px] text-gray-400 mt-2 italic">* หากไม่ต้องการเปลี่ยน ให้เว้นว่างไว้</p>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-indigo-700 transition">
                    บันทึกการเปลี่ยนแปลง
                </button>
                
                {{-- ปุ่มลบสตูดิโอ (ถ้าต้องการ) --}}
                <button type="button" onclick="confirmDelete()" class="px-6 bg-red-50 text-red-600 border border-red-100 rounded-2xl font-bold hover:bg-red-100 transition">
                    ลบ
                </button>
            </div>
        </form>

        {{-- Form สำหรับลบข้อมูลแยกต่างหากเพื่อความปลอดภัย --}}
        <form id="delete-form" action="{{ route('provider.studios.destroy', $studio->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสตูดิโอนี้? ข้อมูลการจองที่เกี่ยวข้องอาจได้รับผลกระทบ')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>

</body>
</html>