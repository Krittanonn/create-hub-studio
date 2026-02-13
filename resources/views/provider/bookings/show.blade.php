<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดการจอง #{{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen p-6 md:p-10">

    <div class="max-w-4xl mx-auto">

        <!-- TOP BAR -->
        <div class="flex justify-between items-center mb-10">
            <a href="{{ route('provider.bookings.index') }}"
                class="text-yellow-400 font-medium hover:underline text-sm">
                ← ย้อนกลับ
            </a>

            <span class="px-4 py-1 rounded-full text-xs font-semibold uppercase bg-yellow-500/20 text-yellow-400 border border-yellow-400/30">
                สถานะปัจจุบัน: {{ $booking->status }}
            </span>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- LEFT SECTION -->
            <div class="md:col-span-2 space-y-8">

                <!-- BOOKING INFO -->
                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5">

                    <h2 class="text-2xl font-semibold mb-6 border-b border-white/10 pb-4">
                        รายละเอียดการจอง
                    </h2>

                    <div class="grid grid-cols-2 gap-y-8 text-sm">

                        <div>
                            <p class="text-gray-500 text-xs uppercase mb-2">สตูดิโอที่จอง</p>
                            <p class="font-semibold text-lg text-yellow-400">
                                {{ $booking->studio->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs uppercase mb-2">ลูกค้า</p>
                            <p class="font-semibold text-lg">
                                {{ $booking->user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs uppercase mb-2">วัน/เวลาเริ่มต้น</p>
                            <p>{{ $booking->start_time->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-xs uppercase mb-2">วัน/เวลาสิ้นสุด</p>
                            <p>{{ $booking->end_time->format('d/m/Y H:i') }}</p>
                        </div>

                    </div>

                    <div class="mt-10 p-5 bg-[#0F1525] rounded-xl border border-white/5">
                        <p class="text-gray-500 text-xs uppercase mb-3">
                            หมายเหตุจากลูกค้า
                        </p>
                        <p class="text-sm italic text-gray-400">
                            "{{ $booking->note ?? 'ไม่มีข้อความเพิ่มเติม' }}"
                        </p>
                    </div>

                </div>


                <!-- EXTRA SERVICES -->
                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5">

                    <h3 class="font-semibold mb-6">
                        บริการเสริมที่เลือก
                    </h3>

                    <ul class="space-y-4 text-sm">

                        @forelse($booking->items ?? [] as $item)

                        <li class="flex justify-between border-b border-white/5 pb-3">
                            <span>{{ $item->name }} (x{{ $item->quantity }})</span>
                            <span class="font-semibold text-yellow-400">
                                ฿{{ number_format($item->price) }}
                            </span>
                        </li>

                        @empty

                        <li class="text-gray-500 italic text-center py-6">
                            ไม่มีบริการเสริมในการจองนี้
                        </li>

                        @endforelse

                        <li class="flex justify-between text-lg font-semibold pt-6 border-t border-white/10 text-yellow-400">
                            <span>ยอดเงินรวมทั้งสิ้น</span>
                            <span>฿{{ number_format($booking->total_price, 2) }}</span>
                        </li>

                    </ul>

                </div>

            </div>


            <!-- RIGHT SECTION -->
            <div class="md:col-span-1 space-y-8">

                <!-- PAYMENT SLIP -->
                <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">

                    <h3 class="font-semibold mb-5 text-center">
                        หลักฐานการโอนเงิน
                    </h3>

                    <div class="rounded-xl overflow-hidden border border-white/5 bg-[#0F1525] aspect-[3/4] flex items-center justify-center relative group">

                        @if($booking->payment && $booking->payment->slip_url)

                        <img src="{{ asset('storage/' . $booking->payment->slip_url) }}"
                            class="w-full h-full object-cover">

                        <a href="{{ asset('storage/' . $booking->payment->slip_url) }}"
                            target="_blank"
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition">
                            ขยายรูปสลิป
                        </a>

                        @else

                        <p class="text-gray-500 text-xs italic text-center p-4">
                            ยังไม่ได้แนบหลักฐาน<br>หรือแจ้งชำระเงิน
                        </p>

                        @endif

                    </div>

                </div>


                <!-- STATUS ACTION -->
                <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">

                    <h4 class="font-semibold mb-5 text-center">
                        จัดการสถานะ
                    </h4>

                    <form action="{{ route('provider.bookings.update-status', $booking->id) }}"
                        method="POST"
                        class="space-y-4">

                        @csrf
                        @method('PATCH')

                        <button name="status"
                            value="confirmed"
                            class="w-full bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                            ยืนยันการรับจอง
                        </button>

                        <button name="status"
                            value="cancelled"
                            class="w-full bg-red-500/20 text-red-400 py-3 rounded-xl font-semibold hover:bg-red-500 hover:text-white transition"
                            onclick="return confirm('ยืนยันการปฏิเสธการจองนี้?')">
                            ปฏิเสธรายการ
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>