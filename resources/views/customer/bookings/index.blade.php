<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen">

<div class="max-w-5xl mx-auto py-14 px-4">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h1 class="text-4xl font-black italic uppercase tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-500">My Bookings</h1>
            <p class="text-blue-300/50 mt-2 font-medium">ติดตามสถานะรายการจองของคุณ</p>
        </div>
        <a href="{{ route('customer.explore.index') }}" class="bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-6 py-3 rounded-2xl font-bold transition-all border border-blue-500/20 shadow-lg">
            จองเพิ่ม +
        </a>
    </div>

    <div class="space-y-6">
        @forelse($bookings as $booking)
        <div class="group bg-[#111C33]/50 p-8 rounded-[2.5rem] border border-blue-900/30 hover:border-blue-500/40 transition-all duration-500 shadow-xl relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-6">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center text-blue-500 text-2xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-1">{{ $booking->studio->name }}</h3>
                        <p class="text-blue-300/60 text-sm flex items-center">
                            <i class="fa-solid fa-calendar mr-2"></i> {{ $booking->booking_date }} 
                            <span class="mx-3 text-blue-900">|</span> 
                            <i class="fa-solid fa-clock mr-2"></i> {{ $booking->start_time }} - {{ $booking->end_time }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:items-end gap-3">
                    @php
                        $statusClasses = [
                            'pending_payment' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                            'waiting_verify'  => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                            'confirmed'       => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'cancelled'       => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'completed'       => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                        ];
                        $statusText = [
                            'pending_payment' => 'รอชำระเงิน',
                            'waiting_verify'  => 'รอตรวจสอบสลิป',
                            'confirmed'       => 'จองสำเร็จ',
                            'cancelled'       => 'ยกเลิกแล้ว',
                            'completed'       => 'ใช้งานเสร็จสิ้น',
                        ];
                    @endphp
                    <span class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest border {{ $statusClasses[$booking->status] ?? 'bg-gray-500/10' }}">
                        {{ $statusText[$booking->status] ?? $booking->status }}
                    </span>
                    <a href="{{ route('customer.bookings.show', $booking->id) }}" class="text-blue-400 hover:text-white font-bold transition-all flex items-center group/btn">
                        ดูรายละเอียดบิล <i class="fa-solid fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-24 bg-[#111C33]/20 rounded-[3rem] border border-dashed border-blue-900/40">
            <p class="text-blue-300/40 italic">คุณยังไม่มีรายการจองในขณะนี้</p>
        </div>
        @endforelse

        <div class="mt-10">
            {{ $bookings->links() }}
        </div>
    </div>
</div>

</body>
</html>