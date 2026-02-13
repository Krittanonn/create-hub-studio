<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรายการจอง - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen">

    <!-- HEADER -->
    <nav class="bg-[#0F1525] border-b border-white/5 p-5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            <div class="flex items-center gap-4">
                <a href="{{ route('provider.dashboard') }}"
                    class="text-yellow-400 hover:underline text-lg">
                    ←
                </a>
                <h1 class="text-xl font-semibold">
                    ตารางการจองลูกค้า
                </h1>
            </div>

            <div class="flex items-center gap-3 bg-yellow-500/10 px-4 py-1.5 rounded-full border border-yellow-400/30">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-sm font-medium text-yellow-400">Live Bookings</span>
            </div>

        </div>
    </nav>


    <main class="max-w-7xl mx-auto p-6 lg:p-10">

        <!-- TOP SECTION -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">

            <div>
                <h2 class="text-2xl font-semibold">
                    รายการจองทั้งหมด
                </h2>
                <p class="text-gray-500 text-sm">
                    ตรวจสอบและจัดการสถานะการจองสตูดิโอของคุณ
                </p>
            </div>

            <div class="flex bg-[#131A2E] p-1 rounded-xl border border-white/5">
                <button class="px-6 py-2 bg-yellow-500 text-black rounded-lg text-sm font-semibold">
                    ทั้งหมด
                </button>
                <button class="px-6 py-2 text-gray-400 hover:text-yellow-400 rounded-lg text-sm transition">
                    รอชำระเงิน
                </button>
                <button class="px-6 py-2 text-gray-400 hover:text-yellow-400 rounded-lg text-sm transition">
                    ยืนยันแล้ว
                </button>
            </div>

        </div>


        <!-- BOOKINGS -->
        <div class="grid grid-cols-1 gap-8">

            @forelse($bookings ?? [] as $booking)

            <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden hover:border-yellow-400/40 transition">

                <div class="flex flex-col md:flex-row">

                    <!-- LEFT ORDER INFO -->
                    <div class="md:w-48 bg-[#0F1525] p-6 flex flex-col justify-center items-center border-r border-white/5">

                        <span class="text-xs text-gray-500 uppercase mb-2">Order ID</span>

                        <span class="font-mono text-yellow-400 font-semibold">
                            #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                        </span>

                        <div class="mt-4 px-3 py-1 rounded-full text-xs font-semibold uppercase
                        {{ $booking->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400' :
                           ($booking->status == 'confirmed' ? 'bg-green-500/20 text-green-400' :
                           'bg-red-500/20 text-red-400') }}">
                            {{ $booking->status }}
                        </div>

                    </div>


                    <!-- CENTER INFO -->
                    <div class="flex-1 p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">

                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#0F1525] rounded-2xl flex items-center justify-center border border-white/10">
                                🏠
                            </div>
                            <div>
                                <h4 class="font-semibold">
                                    {{ $booking->studio->name }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    {{ $booking->studio->location }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">
                                วันและเวลาที่จอง
                            </p>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="font-semibold">
                                    {{ $booking->start_time->format('d M Y') }}
                                </span>
                                <span class="text-gray-500">|</span>
                                <span>
                                    {{ $booking->start_time->format('H:i') }}
                                    -
                                    {{ $booking->end_time->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col md:items-end">
                            <p class="text-xs text-gray-500 uppercase mb-1">
                                ยอดชำระสุทธิ
                            </p>
                            <span class="text-2xl font-semibold text-yellow-400">
                                ฿{{ number_format($booking->total_price, 2) }}
                            </span>
                        </div>

                    </div>


                    <!-- RIGHT ACTION -->
                    <div class="bg-[#0F1525] md:w-56 p-6 flex flex-col justify-center gap-3 border-l border-white/5">

                        <a href="{{ route('provider.bookings.show', $booking->id) }}"
                            class="text-center py-2 text-sm font-semibold bg-[#131A2E] border border-white/10 rounded-xl hover:bg-white/5 transition">
                            ดูรายละเอียด
                        </a>

                        @if($booking->status == 'pending')

                        <div class="flex gap-2">

                            <form action="{{ route('provider.bookings.update-status', $booking->id) }}"
                                method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit"
                                    class="w-full py-2 bg-green-500 text-white text-xs font-semibold rounded-xl hover:bg-green-600 transition">
                                    ยืนยัน
                                </button>
                            </form>

                            <form action="{{ route('provider.bookings.update-status', $booking->id) }}"
                                method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="w-full py-2 bg-red-500/20 text-red-400 text-xs font-semibold rounded-xl hover:bg-red-500 hover:text-white transition">
                                    ปฏิเสธ
                                </button>
                            </form>

                        </div>

                        @endif

                    </div>

                </div>

            </div>

            @empty

            <div class="bg-[#131A2E] rounded-2xl p-20 text-center border border-dashed border-white/10 text-gray-500">
                <div class="text-6xl mb-4 text-yellow-400">📅</div>
                <h3 class="text-lg font-semibold">
                    ยังไม่มีรายการจองเข้ามา
                </h3>
                <p class="text-gray-500 mt-2">
                    เมื่อมีลูกค้าจองสตูดิโอของคุณ รายการจะมาปรากฏที่นี่
                </p>
            </div>

            @endforelse

        </div>


        <!-- BOTTOM INFO SECTION -->
        <div class="mt-14 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-[#131A2E] rounded-2xl p-8 border border-white/5 relative overflow-hidden">
                <h3 class="text-lg font-semibold mb-4">
                    ระบบจัดการคิวอัตโนมัติ
                </h3>
                <p class="text-gray-400 text-sm mb-6">
                    คุณสามารถตั้งค่าเปิด/ปิด วันที่รับจองได้ที่เมนู "จัดการตารางเวลา"
                    เพื่อป้องกันการจองซ้อน
                </p>
                <a href="{{ route('provider.availability.index') }}"
                    class="inline-block bg-yellow-500 text-black px-6 py-2 rounded-xl text-sm font-semibold hover:bg-yellow-400 transition">
                    จัดการตารางเวลา
                </a>
            </div>

            <div class="bg-[#131A2E] rounded-2xl p-8 border border-white/5">
                <h3 class="text-lg font-semibold text-yellow-400 mb-4">
                    Tips สำหรับคุณ!
                </h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li>✅ รีบยืนยันการจองภายใน 1 ชม. เพื่อเพิ่มคะแนนร้าน</li>
                    <li>📸 อัปโหลดรูปสตูดิโอให้ครบทุกมุมเพื่อเพิ่มโอกาสจอง</li>
                    <li>📞 ติดต่อลูกค้าทันทีหากต้องการสอบถามรายละเอียดเพิ่ม</li>
                </ul>
            </div>

        </div>

    </main>

</body>

</html>