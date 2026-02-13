<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนสตูดิโอ - Create Hub</title>
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
        <div class="mb-10">
            <a href="{{ route('provider.studios.index') }}"
                class="text-yellow-400 text-sm font-medium hover:underline">
                ← ยกเลิกและกลับไป
            </a>

            <h1 class="text-3xl font-semibold mt-3">
                ลงทะเบียนสตูดิโอใหม่
            </h1>

            <p class="text-gray-400 mt-2 text-sm">
                กรุณากรอกข้อมูลให้ครบถ้วนเพื่อให้ Admin ตรวจสอบและอนุมัติ
            </p>
        </div>


        <form action="{{ route('provider.studios.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8">

            @csrf


            <!-- BASIC INFO -->
            <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">

                <h3 class="font-semibold text-lg border-b border-white/10 pb-3">
                    ข้อมูลเบื้องต้น
                </h3>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        ชื่อสตูดิโอ *
                    </label>
                    <input type="text"
                        name="name"
                        required
                        placeholder="เช่น Studio 1 - Natural Light"
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        ที่ตั้ง / ทำเล *
                    </label>
                    <input type="text"
                        name="location"
                        required
                        placeholder="เช่น ย่านอารีย์, กรุงเทพฯ"
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            ราคาเช่าต่อชั่วโมง (บาท) *
                        </label>
                        <input type="number"
                            name="price_per_hour"
                            required
                            placeholder="500"
                            class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-2">
                            ขนาดพื้นที่ (ตร.ม.)
                        </label>
                        <input type="number"
                            name="size"
                            placeholder="40"
                            class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none">
                    </div>

                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        รายละเอียดเพิ่มเติม
                    </label>
                    <textarea name="description"
                        rows="4"
                        placeholder="อธิบายจุดเด่นของสตูดิโอคุณ..."
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none"></textarea>
                </div>

            </div>


            <!-- IMAGE SECTION -->
            <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 space-y-6">

                <h3 class="font-semibold text-lg border-b border-white/10 pb-3">
                    รูปภาพและสื่อ
                </h3>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        อัปโหลดรูปภาพหลัก (Cover Image)
                    </label>

                    <input type="file"
                        name="image"
                        class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-dashed border-white/20 text-sm">

                    <p class="text-xs text-gray-500 mt-2">
                        แนะนำขนาด 1200x800px ไฟล์ .jpg หรือ .png
                    </p>
                </div>

            </div>


            <!-- SUBMIT BUTTON -->
            <button type="submit"
                class="w-full bg-yellow-500 text-black py-4 rounded-2xl font-semibold text-lg hover:bg-yellow-400 transition">
                ส่งข้อมูลให้ Admin อนุมัติ
            </button>

        </form>

    </div>

</body>

</html>