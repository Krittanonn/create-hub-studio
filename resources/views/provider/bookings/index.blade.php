<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรายการจอง - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-indigo-900 text-white p-4 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('provider.dashboard') }}" class="text-2xl hover:bg-white/10 w-10 h-10 flex items-center justify-center rounded-full transition">←</a>
                <h1 class="text-xl font-bold tracking-wide">ตารางการจองลูกค้า</h1>
            </div>
            <div class="flex items-center gap-3 bg-indigo-800 px-4 py-1.5 rounded-full border border-indigo-700">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-sm font-medium">Live Bookings</span>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6 lg:p-10">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">รายการจองทั้งหมด</h2>
                <p class="text-gray-500 text-sm">ตรวจสอบและจัดการสถานะการจองสตูดิโอของคุณ</p>
            </div>
            <div class="flex bg-white p-1 rounded-xl shadow-sm border">
                <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md">ทั้งหมด</button>
                <button class="px-6 py-2 text-gray-500 hover:text-indigo-600 rounded-lg text-sm font-medium transition">รอชำระเงิน</button>
                <button class="px-6 py-2 text-gray-500 hover:text-indigo-600 rounded-lg text-sm font-medium transition">ยืนยันแล้ว</button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @forelse($bookings ?? [] as $booking)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="flex flex-col md:flex-row">
                    
                    <div class="md:w-48 bg-gray-50 p-6 flex flex-col justify-center items-center border-r border-gray-100">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Order ID</span>
                        <span class="font-mono text-indigo-600 font-bold">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <div class="mt-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                               ($booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                            {{ $booking->status }}
                        </div>
                    </div>

                    <div class="flex-1 p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-xl text-indigo-600">🏠</div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $booking->studio->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $booking->studio->location }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">วันและเวลาที่จอง</p>
                            <div class="flex items-center gap-2 text-gray-700">
                                <span class="font-bold text-sm">{{ $booking->start_time->format('d M Y') }}</span>
                                <span class="text-indigo-400">|</span>
                                <span class="text-sm">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col md:items-end">
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">ยอดชำระสุทธิ</p>
                            <span class="text-2xl font-bold text-gray-800">฿{{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50/50 md:w-56 p-6 flex flex-col justify-center gap-2 border-l border-gray-100">
                        <a href="{{ route('provider.bookings.show', $booking->id) }}" class="text-center py-2 text-sm font-bold text-gray-600 bg-white border rounded-xl hover:bg-gray-100 transition shadow-sm">
                            ดูรายละเอียด
                        </a>

                        @if($booking->status == 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('provider.bookings.update-status', $booking->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="w-full py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 shadow-md transition">
                                    ยืนยันรับจอง
                                </button>
                            </form>
                            <form action="{{ route('provider.bookings.update-status', $booking->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="w-full py-2 bg-white text-red-500 border border-red-100 text-xs font-bold rounded-xl hover:bg-red-50 transition">
                                    ปฏิเสธ
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-xl font-bold text-gray-700">ยังไม่มีรายการจองเข้ามา</h3>
                <p class="text-gray-400 mt-2">เมื่อมีลูกค้าจองสตูดิโอของคุณ รายการจะมาปรากฏที่นี่</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-indigo-900 rounded-3xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold mb-4">ระบบจัดการคิวอัตโนมัติ</h3>
                    <p class="text-indigo-200 text-sm mb-6">คุณสามารถตั้งค่าเปิด/ปิด วันที่รับจองได้ที่เมนู "จัดการตารางเวลา" เพื่อป้องกันการจองซ้อน</p>
                    <a href="{{ route('provider.availability.index') }}" class="inline-block bg-white text-indigo-900 px-6 py-2 rounded-xl text-sm font-bold">จัดการตารางเวลา</a>
                </div>
                <div class="absolute -right-5 -bottom-5 text-8xl opacity-10">🕒</div>
            </div>
            
            <div class="bg-white rounded-3xl p-8 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 italic text-indigo-600">Tips สำหรับคุณ!</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-center gap-2">✅ รีบยืนยันการจองภายใน 1 ชม. เพื่อเพิ่มคะแนนร้าน</li>
                    <li class="flex items-center gap-2">📸 อัปโหลดรูปสตูดิโอให้ครบทุกมุมเพื่อเพิ่มโอกาสจอง</li>
                    <li class="flex items-center gap-2">📞 ติดต่อลูกค้าทันทีหากต้องการสอบถามรายละเอียดเพิ่ม</li>
                </ul>
            </div>
        </div>
    </main>

</body>
</html>