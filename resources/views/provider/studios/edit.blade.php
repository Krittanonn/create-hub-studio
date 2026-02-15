<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไข: {{ $studio->name }} - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white p-10">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('provider.studios.index') }}" class="text-gray-500 hover:text-white mb-6 inline-block transition">← ยกเลิก</a>
        
        <div class="bg-[#131A2E] rounded-3xl border border-white/5 p-8">
            <h1 class="text-2xl font-bold mb-8">แก้ไขข้อมูลสตูดิโอ</h1>

            <form action="{{ route('provider.studios.update', $studio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf 
                @method('PATCH')

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

                <div class="space-y-3">
                    <label class="text-sm text-gray-400">รูปภาพปัจจุบัน (ติ๊กถูกเพื่อลบรูปที่ไม่ต้องการ)</label>
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                        {{-- แก้ไข: เปลี่ยนจาก $studio->media เป็น $studio->images ให้ตรงกับ Model --}}
                        @if(isset($studio->images) && $studio->images->count() > 0)
                            @foreach($studio->images as $image)
                                <div class="relative group aspect-square rounded-xl overflow-hidden border border-white/10">
                                    {{-- อ้างอิงตาม Migration: file_path --}}
                                    <img src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover">
                                    
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <label class="cursor-pointer flex flex-col items-center">
                                            <input type="checkbox" name="delete_media[]" value="{{ $image->id }}" class="w-5 h-5 accent-red-500">
                                            <span class="text-[10px] mt-1 text-red-400">ลบรูปนี้</span>
                                        </label>
                                    </div>

                                    @if($image->is_primary)
                                        <span class="absolute top-2 left-2 bg-blue-600 text-[10px] px-2 py-0.5 rounded-full">รูปหลัก</span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-full py-4 bg-[#0B0F1A] rounded-xl text-center border border-white/5">
                                <p class="text-gray-500 text-sm italic">ยังไม่มีรูปภาพสตูดิโอ</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-sm text-gray-400">อัปโหลดรูปภาพเพิ่มเติม</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-white/10 border-dashed rounded-xl cursor-pointer bg-[#0B0F1A] hover:bg-white/5 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-plus text-xl text-gray-500 mb-2"></i>
                                <p class="text-xs text-gray-500">คลิกเพื่อเพิ่มรูปใหม่</p>
                            </div>
                            <input type="file" name="images[]" id="image-input" multiple accept="image/*" class="hidden" />
                        </label>
                    </div>
                    <div id="image-preview" class="grid grid-cols-4 gap-4 mt-4"></div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">ความจุ (คน)</label>
                    <input type="number" name="capacity" value="{{ $studio->capacity }}" class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm text-gray-400">รายละเอียด</label>
                    <textarea name="description" rows="5" required class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:border-blue-500 outline-none transition">{{ $studio->description }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-xl font-bold transition shadow-lg shadow-blue-900/20">
                    อัปเดตข้อมูลและรูปภาพ
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
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded-lg overflow-hidden border border-white/10';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(files[i]);
            }
        });
    </script>
</body>
</html>