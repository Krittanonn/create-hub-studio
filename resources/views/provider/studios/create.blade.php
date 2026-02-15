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

            <form action="{{ route('provider.studios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                <div class="space-y-3">
                    <label class="text-sm text-gray-400 text-sm">รูปภาพสตูดิโอ (เลือกได้หลายรูป) <span class="text-red-500">*</span></label>
                    
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-white/10 border-dashed rounded-xl cursor-pointer bg-[#0B0F1A] hover:bg-white/5 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-500 mb-2"></i>
                                <p class="text-xs text-gray-500 uppercase">Click to upload images</p>
                            </div>
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="image-input" required />
                        </label>
                    </div>

                    <div id="image-preview" class="grid grid-cols-4 gap-4 mt-4">
                        </div>
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

    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ''; 
            
            const files = event.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded-lg overflow-hidden border border-white/10';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        ${i === 0 ? '<span class="absolute top-1 left-1 bg-blue-600 text-[10px] px-2 py-0.5 rounded-full">รูปหลัก</span>' : ''}
                    `;
                    previewContainer.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>