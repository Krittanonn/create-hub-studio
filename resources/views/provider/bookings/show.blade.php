<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการจอง #{{ $booking->id }} - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <main class="flex-1 p-10">
        <div class="max-w-4xl mx-auto">
            <header class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-4">
                    <a href="{{ route('provider.bookings.index') }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold">รายละเอียดการจอง #{{ $booking->id }}</h1>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-8">
                        <h3 class="text-lg font-semibold mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-blue-500"></i> ข้อมูลการจอง
                        </h3>
                        <div class="grid grid-cols-2 gap-y-6">
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">สตูดิโอ</p>
                                <p class="font-medium">{{ $booking->studio->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">ลูกค้า</p>
                                <p class="font-medium">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">วันที่</p>
                                <p class="font-medium">{{ $booking->start_time->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-1">เวลา</p>
                                <p class="font-medium">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-8">
                        <h3 class="text-lg font-semibold mb-6">รายการเช่าเพิ่มเติม</h3>
                        <div class="space-y-4">
                            @foreach($booking->items as $item)
                            <div class="flex justify-between items-center py-3 border-b border-white/5 last:border-0">
                                <div>
                                    <p class="font-medium">{{ $item->itemable->name }}</p>
                                    <p class="text-xs text-gray-500">{{ class_basename($item->itemable_type) }} x {{ $item->quantity }}</p>
                                </div>
                                <p class="font-bold text-blue-400">฿{{ number_format($item->price_at_time * $item->quantity, 2) }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-blue-600 rounded-2xl p-8 shadow-xl shadow-blue-900/20">
                        <p class="text-blue-200 text-sm mb-1">ยอดเงินรวมทั้งหมด</p>
                        <h2 class="text-4xl font-bold mb-6">฿{{ number_format($booking->total_price, 2) }}</h2>
                        <div class="pt-6 border-t border-blue-500 flex justify-between items-center text-sm">
                            <span class="text-blue-200">สถานะชำระเงิน</span>
                            <span class="font-bold uppercase tracking-widest text-[10px] bg-white/20 px-2 py-1 rounded">
                                {{ $booking->payment_status }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-6 space-y-3">
                        <p class="text-sm font-semibold mb-2">อัปเดตสถานะงาน</p>
                        @if($booking->status === 'pending')
                            <p class="text-xs text-gray-500 italic">รอการตรวจสอบยอดเงินจาก Admin เพื่อยืนยันงานโดยอัตโนมัติ</p>
                        @else
                            <p class="text-xs text-gray-400">สถานะปัจจุบัน: <span class="text-white uppercase font-bold">{{ $booking->status }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>