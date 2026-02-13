<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเวลาว่าง - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen">

<!-- HEADER -->
<nav class="bg-[#0F1525] border-b border-white/5 p-5">
    <div class="max-w-6xl mx-auto flex items-center gap-4">
        <a href="{{ route('provider.dashboard') }}"
           class="text-yellow-400 hover:underline text-lg">
            ←
        </a>
        <h1 class="text-xl font-semibold">
            จัดการตารางเวลาเปิด-ปิด
        </h1>
    </div>
</nav>


<main class="max-w-6xl mx-auto p-6 lg:p-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- LEFT FORM -->
        <div class="lg:col-span-1">

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 sticky top-24">

                <h3 class="text-lg font-semibold mb-4">
                    เพิ่มวันหยุด / ปิดรับจอง
                </h3>

                <p class="text-gray-500 text-xs mb-6">
                    ระบุช่วงวันที่คุณต้องการปิดสตูดิโอ
                </p>

                <form action="{{ route('provider.availability.store') }}"
                      method="POST"
                      class="space-y-5">

                    @csrf

                    <div>
                        <label class="block text-xs text-gray-400 mb-2">
                            เลือกสตูดิโอ
                        </label>
                        <select name="studio_id"
                                class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
                            @foreach($studios ?? [] as $studio)
                                <option value="{{ $studio->id }}">
                                    {{ $studio->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-2">
                            วันที่เริ่ม
                        </label>
                        <input type="date"
                               name="start_date"
                               required
                               class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-2">
                            วันที่สิ้นสุด
                        </label>
                        <input type="date"
                               name="end_date"
                               required
                               class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-2">
                            สาเหตุ (ถ้ามี)
                        </label>
                        <input type="text"
                               name="note"
                               placeholder="เช่น ปิดปรับปรุงร้าน"
                               class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
                    </div>

                    <button type="submit"
                            class="w-full bg-yellow-500 text-black py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
                        ยืนยันการปิดรับจอง
                    </button>

                </form>

            </div>

        </div>


        <!-- RIGHT TABLE -->
        <div class="lg:col-span-2 space-y-8">

            <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

                <div class="p-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="font-semibold">
                        รายการวันที่ปิดรับจอง
                    </h3>

                    <span class="text-xs text-yellow-400 bg-yellow-500/10 px-3 py-1 rounded-full uppercase border border-yellow-400/30">
                        Active Rules
                    </span>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="text-xs text-gray-500 uppercase tracking-wider border-b border-white/5">
                            <tr>
                                <th class="p-6">สตูดิโอ</th>
                                <th class="p-6">ระยะเวลาที่ปิด</th>
                                <th class="p-6">สาเหตุ</th>
                                <th class="p-6 text-center">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($availabilities ?? [] as $item)

                            <tr class="border-b border-white/5 hover:bg-white/5 transition">

                                <td class="p-6 font-semibold">
                                    {{ $item->studio->name }}
                                </td>

                                <td class="p-6 text-gray-400">
                                    {{ $item->start_date }} ถึง {{ $item->end_date }}
                                </td>

                                <td class="p-6 text-gray-500 italic text-sm">
                                    {{ $item->note ?? 'ไม่ได้ระบุสาเหตุ' }}
                                </td>

                                <td class="p-6 text-center">

                                    <form action="{{ route('provider.availability.destroy', $item->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-400 hover:text-red-300 font-semibold text-xs"
                                                onclick="return confirm('ต้องการยกเลิกการปิดรับจองใช่หรือไม่?')">
                                            เปิดรับจองใหม่
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="4"
                                    class="p-16 text-center text-gray-500 italic">

                                    <div class="text-5xl mb-4 text-yellow-400">🗓️</div>
                                    ยังไม่มีการตั้งค่าวันหยุดเป็นพิเศษ<br>
                                    <span class="text-xs text-gray-600">
                                        สตูดิโอของคุณเปิดรับจองทุกวันตามปกติ
                                    </span>

                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- WARNING BOX -->
            <div class="bg-yellow-500/10 border border-yellow-400/30 rounded-2xl p-6 flex gap-4">

                <span class="text-xl text-yellow-400">⚠️</span>

                <div class="text-sm text-gray-300 leading-relaxed">
                    <p class="font-semibold text-yellow-400 mb-2">
                        ข้อควรระวัง:
                    </p>

                    <p>
                        การปิดรับจองจะมีผลกับปฏิทินที่ลูกค้าเห็นทันที
                        หากมีการจองที่ยืนยันแล้ว ระบบจะยังคงรายการนั้นไว้
                        กรุณาติดต่อลูกค้าโดยตรงหากต้องการขยับคิวงาน
                    </p>
                </div>

            </div>

        </div>

    </div>

</main>

</body>
</html>
