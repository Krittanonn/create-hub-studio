<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดการจอง #{{ $booking->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen">

<div class="max-w-3xl mx-auto py-14 px-4">
    <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-bold mb-8 transition-all group">
        <i class="fa-solid fa-chevron-left mr-2 group-hover:-translate-x-1"></i> กลับไปรายการจองทั้งหมด
    </a>

    <div class="bg-[#111C33]/80 backdrop-blur-xl rounded-[3rem] border border-blue-900/40 shadow-2xl overflow-hidden">
        <div class="p-10 border-b border-blue-900/30 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-black mb-2">{{ $booking->studio->name }}</h1>
                <p class="text-blue-400 font-bold tracking-widest uppercase text-xs">Booking ID: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            {{-- ตรวจสอบสถานะให้ตรงกับที่คุณใช้ (เช่น pending หรือ pending_payment) --}}
            @if($booking->status === 'pending' || $booking->status === 'pending_payment')
                <a href="{{ route('customer.payments.show', $booking->id) }}" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg shadow-blue-600/20">
                    ชำระเงินตอนนี้
                </a>
            @endif
        </div>

        <div class="p-10 space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-blue-300/40 font-bold uppercase mb-1">วันที่จอง</p>
                    <p class="font-bold">{{ $booking->start_time->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-blue-300/40 font-bold uppercase mb-1">เวลา</p>
                    <p class="font-bold">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                </div>
            </div>

            <div class="space-y-4 pt-6 border-t border-blue-900/20">
                <h3 class="font-bold text-blue-300">สรุปรายการค่าใช้จ่าย</h3>
                
                <div class="flex justify-between text-sm">
                    <span>ค่าสตูดิโอ (ฐาน)</span>
                    {{-- คำนวณค่าฐานโดยนำยอดรวม ลบ ผลรวมของรายการเสริมใน items --}}
                    <span>฿{{ number_format($booking->total_price - $booking->items->sum(fn($i) => $i->price_at_time * $i->quantity), 2) }}</span>
                </div>

                {{-- แสดงอุปกรณ์เสริมผ่าน Accessor: equipment_items --}}
                @foreach($booking->equipment_items as $item)
                <div class="flex justify-between text-sm italic text-blue-100/60">
                    <span>- {{ $item->itemable->name }} (x{{ $item->quantity }})</span>
                    <span>฿{{ number_format($item->price_at_time * $item->quantity, 2) }}</span>
                </div>
                @endforeach

                {{-- แสดงพนักงานผ่าน Accessor: staff_items --}}
                @foreach($booking->staff_items as $item)
                <div class="flex justify-between text-sm italic text-blue-100/60">
                    <span>- พนักงาน: {{ $item->itemable->name }}</span>
                    <span>฿{{ number_format($item->price_at_time * $item->quantity, 2) }}</span>
                </div>
                @endforeach

                <div class="flex justify-between items-end pt-6 border-t border-blue-900/30">
                    <span class="text-xl font-bold">ยอดสุทธิ</span>
                    <span class="text-3xl font-black text-blue-400">฿{{ number_format($booking->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        @if($booking->status === 'pending' || $booking->status === 'pending_payment')
        <div class="p-10 bg-[#0F1A2F]/50 border-t border-blue-900/30">
            <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('ยืนยันการยกเลิกการจอง?')">
                @csrf
                <button type="submit" class="text-red-500/70 hover:text-red-500 text-sm font-bold transition-all flex items-center">
                    <i class="fa-solid fa-circle-xmark mr-2"></i> ต้องการยกเลิกรายการจองนี้?
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

</body>
</html>