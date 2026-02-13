<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>แก้ไขสตูดิโอ - {{ $studio->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white p-6 md:p-10">

    <div class="max-w-3xl mx-auto">

        <!-- HEADER -->
        <div class="mb-10 flex justify-between items-end">
            <div>
                <a href="{{ route('provider.studios.index') }}"
                    class="text-yellow-400 font-medium text-sm hover:underline">
                    ← กลับไปรายการสตูดิโอ
                </a>

                <h1 class="text-3xl font-semibold mt-3">
                    แก้ไขข้อมูลสตูดิโอ
                </h1>

                <p class="text-gray-400 mt-2 text-sm">
                    สตูดิโอ: {{ $studio->name }}
                </p>
            </div>

            @if($studio->status == 'active')
            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-medium">
                ออนไลน์อยู่
            </span>
            @endif
        </div>


        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 p-4 rounded-xl mb-8">
            {{ session('success') }}
        </div>
        @endif


        <form action="{{ route('provider.studios.update', $studio->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8">

            @csrf
            @method('PATCH')


            <!-- BASIC INFO CARD -->
            <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">

                <h3 class="font-semibold text-lg border-b border-white/10 pb-3">
                    ข้อมูลที่ต้องการปรับปรุง
                </h3>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        ชื่อสตูดิโอ
                    </label>
                    <input type="text"
                        name="name"
                        value="{{ old('name', $studio->name) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        ที่ตั้ง / ทำเล
                    </label>
                    <input type="text"
                        name="location"
                        value="{{ old('location', $studio->location) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            ราคาเช่าต่อชั่วโมง (บาท)
                        </label>
                        <input type="number"
                            name="price_per_hour"
                            value="{{ old('price_per_hour', $studio->price_per_hour) }}"
                            required
                            class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            ขนาดพื้นที่ (ตร.ม.)
                        </label>
                        <input type="number"
                            name="size"
                            value="{{ old('size', $studio->size) }}"
                            class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                    </div>

                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        รายละเอียดเพิ่มเติม
                    </label>
                    <textarea name="description"
                        rows="4"
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">{{ old('description', $studio->description) }}</textarea>
                </div>

            </div>


            <!-- IMAGE CARD -->
            <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">

                <h3 class="font-semibold text-lg border-b border-white/10 pb-3">
                    รูปภาพสตูดิโอ
                </h3>

                <div>
                    <p class="text-xs text-gray-500 mb-3 uppercase">
                        รูปภาพปัจจุบัน
                    </p>

                    <div class="w-48 h-32 bg-[#0F1525] rounded-xl overflow-hidden border border-white/10">
                        <img src="{{ $studio->image_url ?? 'https://via.placeholder.com/400x300?text=No+Image' }}"
                            class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        เปลี่ยนรูปภาพใหม่ (ถ้ามี)
                    </label>
                    <input type="file"
                        name="image"
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-dashed border-white/20 text-sm">
                    <p class="text-xs text-gray-500 mt-2">
                        * หากไม่ต้องการเปลี่ยน ให้เว้นว่างไว้
                    </p>
                </div>

            </div>


            <!-- ACTION BUTTONS -->
            <div class="flex gap-4">

                <button type="submit"
                    class="flex-1 bg-yellow-500 text-black py-4 rounded-2xl font-semibold hover:bg-yellow-400 transition">
                    บันทึกการเปลี่ยนแปลง
                </button>

                <button type="button"
                    onclick="confirmDelete()"
                    class="px-6 bg-red-500/20 text-red-400 border border-red-500/30 rounded-2xl font-semibold hover:bg-red-500/30 transition">
                    ลบ
                </button>

            </div>

        </form>


        <form id="delete-form"
            action="{{ route('provider.studios.destroy', $studio->id) }}"
            method="POST"
            class="hidden">
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