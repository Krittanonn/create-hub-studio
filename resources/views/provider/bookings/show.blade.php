<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดการจอง #{{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen p-6 md:p-10">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('provider.bookings.index') }}" class="text-indigo-600 font-bold">← ย้อนกลับ</a>
            <div class="flex gap-2">
                <span class="px-4 py-1 rounded-full text-xs font-bold uppercase bg-indigo-100 text-indigo-700 border border-indigo-200">
                    สถานะปัจจุบัน: {{ $booking->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">รายละเอียดการจอง</h2>
                    
                    <div class="grid grid-cols-2 gap-y-6 text-sm">
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px]">สตูดิโอที่จอง</p>
                            <p class="font-bold text-lg text-indigo-900">{{ $booking->studio->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px]">ลูกค้า</p>
                            <p class="font-bold text-lg text-gray-800">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px]">วัน/เวลาเริ่มต้น</p>
                            <p class="font-medium">{{ $booking->start_time->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px]">วัน/เวลาสิ้นสุด</p>
                            <p class="font-medium">{{ $booking->end_time->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-gray-50 rounded-2xl">
                        <p class="text-gray-400 font-bold uppercase text-[10px] mb-2">หมายเหตุจากลูกค้า:</p>
                        <p class="text-sm italic text-gray-600">"{{ $booking->note ?? 'ไม่มีข้อความเพิ่มเติม' }}"</p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">บริการเสริมที่เลือก</h3>
                    <ul class="space-y-3">
                        @forelse($booking->items ?? [] as $item)
                        <li class="flex justify-between text-sm border-b pb-2">
                            <span>{{ $item->name }} (x{{ $item->quantity }})</span>
                            <span class="font-bold">฿{{ number_format($item->price) }}</span>
                        </li>
                        @empty
                        <li class="text-gray-400 text-sm italic text-center py-4">ไม่มีบริการเสริมในการจองนี้</li>
                        @endforelse
                        <li class="flex justify-between text-lg font-bold pt-4 text-indigo-600 underline decoration-double">
                            <span>ยอดเงินรวมทั้งสิ้น</span>
                            <span>฿{{ number_format($booking->total_price, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 text-center">หลักฐานการโอนเงิน</h3>
                    <div class="rounded-2xl overflow-hidden border bg-gray-100 aspect-[3/4] flex items-center justify-center relative group">
                        @if($booking->payment && $booking->payment->slip_url)
                            <img src="{{ asset('storage/' . $booking->payment->slip_url) }}" class="w-full h-full object-cover">
                            <a href="{{ asset('storage/' . $booking->payment->slip_url) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition">ขยายรูปสลิป</a>
                        @else
                            <p class="text-gray-400 text-xs italic text-center p-4">ยังไม่ได้แนบหลักฐาน<br>หรือแจ้งชำระเงิน</p>
                        @endif
                    </div>
                </div>

                <div class="bg-indigo-900 p-6 rounded-3xl shadow-lg">
                    <h4 class="text-white font-bold mb-4 text-sm text-center">จัดการสถานะ</h4>
                    <form action="{{ route('provider.bookings.update-status', $booking->id) }}" method="POST" class="space-y-2">
                        @csrf @method('PATCH')
                        <button name="status" value="confirmed" class="w-full bg-green-500 text-white py-3 rounded-xl font-bold text-sm hover:bg-green-600 transition shadow-md">ยืนยันการรับจอง</button>
                        <button name="status" value="cancelled" class="w-full bg-white/10 text-red-300 py-3 rounded-xl font-bold text-sm hover:bg-red-500 hover:text-white transition" onclick="return confirm('ยืนยันการปฏิเสธการจองนี้?')">ปฏิเสธรายการ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>