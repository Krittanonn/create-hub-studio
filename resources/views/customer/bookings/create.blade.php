<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จอง {{ $studio->name }} | Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen pb-20">

<div class="max-w-4xl mx-auto py-14 px-4">
    <a href="{{ route('customer.explore.show', $studio->id) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-bold mb-8 transition-all group">
        <i class="fa-solid fa-chevron-left mr-2 group-hover:-translate-x-1"></i> กลับไปหน้าสตูดิโอ
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2">
            <form action="{{ route('customer.bookings.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="studio_id" value="{{ $studio->id }}">

                <div class="bg-[#111C33]/50 p-8 rounded-[2.5rem] border border-blue-900/30">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fa-solid fa-calendar-day mr-3 text-blue-500"></i> เลือกวันและเวลา
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2">วันที่ต้องการจอง</label>
                            <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2">เวลาเริ่ม</label>
                            <input type="time" name="start_time" required
                                   class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2">เวลาสิ้นสุด</label>
                            <input type="time" name="end_time" required
                                   class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-[#111C33]/50 p-8 rounded-[2.5rem] border border-blue-900/30">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fa-solid fa-box-open mr-3 text-blue-500"></i> อุปกรณ์เสริม (Optional)
                    </h2>
                    <div class="space-y-4">
                        @foreach($studio->equipments as $item)
                        <div class="flex items-center justify-between bg-[#0F1A2F] p-5 rounded-2xl border border-blue-900/20">
                            <div>
                                <p class="font-bold">{{ $item->name }}</p>
                                <p class="text-sm text-blue-400">฿{{ number_format($item->price_per_unit) }} / ชิ้น</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="number" name="equipment[{{ $item->id }}]" value="0" min="0" 
                                       class="w-20 bg-[#07101F] border border-blue-900/40 rounded-xl px-3 py-2 text-center focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-[#111C33]/50 p-8 rounded-[2.5rem] border border-blue-900/30">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fa-solid fa-user-plus mr-3 text-blue-500"></i> บริการพนักงานเพิ่มเติม
                    </h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($studio->staffs as $staff)
                        <label class="flex items-center p-5 bg-[#0F1A2F] rounded-2xl border border-blue-900/20 cursor-pointer hover:border-blue-500/50 transition-all group">
                            <input type="checkbox" name="staff[]" value="{{ $staff->id }}" class="w-5 h-5 rounded border-blue-900 bg-[#07101F] text-blue-600 focus:ring-blue-500 mr-4">
                            <div class="flex-1">
                                <p class="font-bold group-hover:text-blue-400 transition-colors">{{ $staff->name }}</p>
                                <p class="text-xs text-blue-400">{{ $staff->position }} • ฿{{ number_format($staff->price_per_day) }} / วัน</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-6 rounded-[2rem] shadow-xl shadow-blue-600/20 transition-all transform active:scale-95 text-xl">
                    ยืนยันการจองและไปหน้าบิล
                </button>
            </form>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-10 bg-gradient-to-br from-[#1E2E4D] to-[#111C33] p-8 rounded-[2.5rem] border border-blue-500/30 shadow-2xl">
                <h3 class="font-bold text-lg mb-4">สรุปเบื้องต้น</h3>
                <div class="space-y-4 text-sm text-blue-100/70 border-b border-blue-900/30 pb-6 mb-6">
                    <div class="flex justify-between">
                        <span>ค่าเช่าสตูดิโอ</span>
                        <span class="text-white font-bold">฿{{ number_format($studio->price_per_hour) }}/ชม.</span>
                    </div>
                </div>
                <div class="p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20">
                    <p class="text-xs text-blue-300 mb-1 italic">*ราคาสุทธิจะถูกคำนวณในหน้าถัดไปหลังจากรวมค่าอุปกรณ์และพนักงานเสริมเรียบร้อยแล้ว</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>