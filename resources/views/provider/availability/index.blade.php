<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเวลาว่าง - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-indigo-900 text-white p-4 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('provider.dashboard') }}" class="text-2xl hover:bg-white/10 w-10 h-10 flex items-center justify-center rounded-full transition">←</a>
                <h1 class="text-xl font-bold">จัดการตารางเวลาเปิด-ปิด</h1>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 lg:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">เพิ่มวันหยุด / ปิดรับจอง</h3>
                    <p class="text-gray-400 text-xs mb-6">ระบุช่วงวันที่คุณต้องการปิดสตูดิโอเพื่อไม่ให้ลูกค้ากดจองได้</p>

                    <form action="{{ route('provider.availability.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">เลือกสตูดิโอ</label>
                            <select name="studio_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                @foreach($studios ?? [] as $studio)
                                    <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">วันที่เริ่ม</label>
                            <input type="date" name="start_date" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">วันที่สิ้นสุด</label>
                            <input type="date" name="end_date" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">สาเหตุ (ถ้ามี)</label>
                            <input type="text" name="note" placeholder="เช่น ปิดปรับปรุงร้าน" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            ยืนยันการปิดรับจอง
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">รายการวันที่ปิดรับจอง</h3>
                        <span class="text-xs text-indigo-500 font-bold bg-indigo-50 px-3 py-1 rounded-full uppercase">Active Rules</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="p-6">สตูดิโอ</th>
                                    <th class="p-6">ระยะเวลาที่ปิด</th>
                                    <th class="p-6">สาเหตุ</th>
                                    <th class="p-6 text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($availabilities ?? [] as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-6 font-bold text-gray-700 text-sm">{{ $item->studio->name }}</td>
                                    <td class="p-6">
                                        <div class="text-xs text-gray-600 font-medium">
                                            {{ $item->start_date }} ถึง {{ $item->end_date }}
                                        </div>
                                    </td>
                                    <td class="p-6 text-xs text-gray-400 italic">
                                        {{ $item->note ?? 'ไม่ได้ระบุสาเหตุ' }}
                                    </td>
                                    <td class="p-6 text-center">
                                        <form action="{{ route('provider.availability.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs" onclick="return confirm('ต้องการยกเลิกการปิดรับจองในวันนี้ใช่หรือไม่?')">
                                                เปิดรับจองใหม่
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center text-gray-300 italic">
                                        <div class="text-4xl mb-4">🗓️</div>
                                        ยังไม่มีการตั้งค่าวันหยุดเป็นพิเศษ<br>
                                        <span class="text-xs text-gray-400">สตูดิโอของคุณเปิดรับจองทุกวันตามปกติ</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-orange-50 border border-orange-100 rounded-2xl p-6 flex gap-4">
                    <span class="text-xl">⚠️</span>
                    <div class="text-sm text-orange-800 leading-relaxed">
                        <p class="font-bold">ข้อควรระวัง:</p>
                        <p>การปิดรับจองจะมีผลกับปฏิทินที่ลูกค้าเห็นทันที หากมีการจองที่ยืนยันไปแล้วในช่วงวันที่คุณเลือกปิด ระบบจะยังคงรายการจองนั้นไว้ กรุณาติดต่อลูกค้าโดยตรงหากต้องการขยับคิวงาน</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>