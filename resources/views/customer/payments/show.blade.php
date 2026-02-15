<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงินการจอง #{{ $booking->id }} | Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen pb-10">

<div class="max-w-2xl mx-auto py-14 px-4">
    
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600/20 rounded-full mb-4">
            <i class="fa-solid fa-file-invoice-dollar text-3xl text-blue-500"></i>
        </div>
        <h1 class="text-3xl font-black italic uppercase tracking-tighter">Payment Summary</h1>
        <p class="text-blue-300/50 font-medium">กรุณาตรวจสอบยอดชำระและแนบหลักฐานการโอนเงิน</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        
        <div class="bg-[#111C33]/80 backdrop-blur-xl rounded-[3rem] border border-blue-900/40 shadow-2xl overflow-hidden">
            <div class="p-8 border-b border-blue-900/30 bg-blue-900/10">
                <h2 class="font-bold text-blue-300 flex items-center">
                    <i class="fa-solid fa-receipt mr-3"></i> รายละเอียดค่าใช้จ่าย
                </h2>
            </div>
            
            <div class="p-8 space-y-4">
                {{-- 1. คำนวณค่าเช่าสตูดิโอพื้นฐาน (ราคารวมลบด้วยราคาของเสริมทั้งหมดใน items) --}}
                <div class="flex justify-between text-sm">
                    <span class="text-blue-300/60">ค่าเช่าสตูดิโอ ({{ $booking->studio->name }})</span>
                    <span class="font-mono text-white">
                        ฿{{ number_format($booking->total_price - $booking->items->sum(function($item) { 
                            return $item->price_at_time * $item->quantity; 
                        }), 2) }}
                    </span>
                </div>

                {{-- 2. แสดงรายการอุปกรณ์เสริมจาก Accessor: equipment_items --}}
                @foreach($booking->equipment_items as $item)
                <div class="flex justify-between text-sm italic">
                    <span class="text-blue-300/40">+ {{ $item->itemable->name }} (x{{ $item->quantity }})</span>
                    <span class="font-mono text-blue-200">฿{{ number_format($item->price_at_time * $item->quantity, 2) }}</span>
                </div>
                @endforeach

                {{-- 3. แสดงรายการพนักงานเสริมจาก Accessor: staff_items --}}
                @foreach($booking->staff_items as $item)
                <div class="flex justify-between text-sm italic">
                    <span class="text-blue-300/40">+ พนักงาน: {{ $item->itemable->name }}</span>
                    <span class="font-mono text-blue-200">฿{{ number_format($item->price_at_time, 2) }}</span>
                </div>
                @endforeach

                <div class="pt-6 border-t border-blue-900/30 flex justify-between items-end">
                    <span class="text-xl font-bold">ยอดที่ต้องชำระสุทธิ</span>
                    <span class="text-4xl font-black text-blue-400 tracking-tighter">฿{{ number_format($booking->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- ส่วนช่องทางการโอนเงิน --}}
        <div class="bg-[#111C33]/50 p-8 rounded-[3rem] border border-blue-900/20 text-center">
            <p class="text-xs font-bold text-blue-300/40 uppercase tracking-widest mb-4">ช่องทางชำระเงิน</p>
            <div class="flex flex-col items-center">
                <div class="bg-white p-2 rounded-2xl mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KrittanonSitePayment" alt="PromptPay QR" class="w-32 h-32">
                </div>
                <p class="font-bold">ธนาคารกสิกรไทย (K-Bank)</p>
                <p class="text-blue-400 font-mono text-lg">012-3-45678-9</p>
                <p class="text-sm text-blue-300/60">ชื่อบัญชี: บจก. ครีเอท ฮับ สตูดิโอ</p>
            </div>
        </div>

        {{-- ส่วนฟอร์มอัปโหลดสลิป --}}
        <div class="bg-gradient-to-br from-[#1E2E4D] to-[#111C33] p-10 rounded-[3rem] border border-blue-400/30 shadow-2xl">
            <h3 class="text-xl font-bold mb-8 text-center">แจ้งหลักฐานการโอนเงิน</h3>
            
            <form action="{{ route('customer.payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-blue-300/50 uppercase mb-3 tracking-widest">แนบรูปภาพสลิป (.jpg, .png)</label>
                    <div class="relative group">
                        <input type="file" name="slip_image" required
                               class="block w-full text-sm text-blue-300
                               file:mr-4 file:py-3 file:px-6
                               file:rounded-2xl file:border-0
                               file:text-sm file:font-bold
                               file:bg-blue-600 file:text-white
                               hover:file:bg-blue-500 file:transition-all
                               bg-[#07101F] border border-blue-900/40 rounded-2xl p-2">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-blue-300/50 uppercase mb-3 tracking-widest">เวลาที่โอนเงิน (ตามสลิป)</label>
                    <div class="relative">
                        <i class="fa-solid fa-clock absolute left-5 top-1/2 -translate-y-1/2 text-blue-500/50"></i>
                        <input type="time" name="transfer_time" required
                               class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl pl-12 pr-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-green-900/20 transition-all transform active:scale-95 text-lg">
                    <i class="fa-solid fa-paper-plane mr-2"></i> ยืนยันการแจ้งชำระเงิน
                </button>
            </form>
        </div>

        <a href="{{ route('customer.bookings.index') }}" class="text-center text-blue-300/40 hover:text-blue-300 text-sm font-medium transition-colors">
            ไว้แจ้งภายหลัง (กลับไปที่รายการจองของฉัน)
        </a>

    </div>
</div>

</body>
</html>