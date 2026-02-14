<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายได้และการถอนเงิน - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 flex flex-col fixed">
        <div class="mb-10">
            <h2 class="text-2xl font-semibold italic text-white">CREATE<span class="text-blue-500">HUB</span></h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Provider Mode</p>
        </div>
        <nav class="space-y-2 flex-1 text-sm overflow-y-auto pr-2 custom-scrollbar">
    <div class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-2 ml-4">Main Menu</div>
    
    <a href="{{ route('provider.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-chart-pie w-5"></i> แผงควบคุม
    </a>

    <a href="{{ route('provider.studios.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.studios.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-house-laptop w-5"></i> สตูดิโอของฉัน
    </a>

    <a href="{{ route('provider.bookings.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.bookings.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-check w-5"></i> รายการจอง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Resources</div>

    <a href="{{ route('provider.equipments.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.equipments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-camera w-5"></i> อุปกรณ์เสริม
    </a>

    <a href="{{ route('provider.staffs.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.staffs.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-user-tie w-5"></i> ทีมงานพนักงาน
    </a>

    <a href="{{ route('provider.availability.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.availability.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-xmark w-5"></i> จัดการช่วงเวลาว่าง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Finance & Community</div>

    <a href="{{ route('provider.payouts.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.payouts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-wallet w-5"></i> การเงิน/ถอนเงิน
    </a>


    <a href="{{ route('provider.reviews.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.reviews.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-star w-5"></i> รีวิวจากลูกค้า
    </a>
</nav>
<div class="mt-auto pt-6 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition group">
                    <i class="fa-solid fa-right-from-bracket group-hover:rotate-180 transition-transform duration-300"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-10">
        
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-white">รายได้และการถอนเงิน</h1>
            <p class="text-gray-400 mt-1">จัดการรายได้จากสตูดิโอและส่งคำขอถอนเงินเข้าบัญชีของคุณ</p>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-8 rounded-3xl shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-blue-100 text-sm font-medium mb-2 opacity-80">ยอดเงินที่ถอนได้ปัจจุบัน</p>
                        <h2 class="text-4xl font-bold text-white">฿{{ number_format($payoutableAmount, 2) }}</h2>
                        <p class="text-blue-200 text-xs mt-4 italic">* เฉพาะรายการจองที่มีสถานะสำเร็จ (Confirmed) เท่านั้น</p>
                    </div>
                    <i class="fa-solid fa-wallet absolute -bottom-4 -right-4 text-white/10 text-9xl rotate-12"></i>
                </div>

                <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                    <h3 class="text-lg font-semibold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-blue-500"></i> ส่งคำขอถอนเงิน
                    </h3>
                    <form action="{{ route('provider.payouts.request') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-400 mb-2">จำนวนเงินที่ต้องการถอน (ขั้นต่ำ 500.-)</label>
                            <input type="number" name="amount" min="500" max="{{ $payoutableAmount }}" step="0.01" 
                                   class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition"
                                   placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-2">ข้อมูลบัญชีธนาคาร (ชื่อ/เลขบัญชี/ธนาคาร)</label>
                            <textarea name="bank_account_info" rows="3" 
                                      class="w-full bg-[#0B0F1A] border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition"
                                      placeholder="เช่น นายสมชาย ใจดี | 123-4-56789-0 | กสิกรไทย" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-white text-black font-bold py-3 rounded-xl hover:bg-gray-200 transition">
                            ยืนยันการขอถอนเงิน
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">
                    <div class="p-6 border-b border-white/5">
                        <h3 class="font-semibold text-lg">ประวัติการถอนเงิน</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white/[0.02] text-gray-400 uppercase text-[10px] tracking-widest">
                                <tr>
                                    <th class="px-6 py-4 font-medium">วันที่ทำรายการ</th>
                                    <th class="px-6 py-4 font-medium">ข้อมูลธนาคาร</th>
                                    <th class="px-6 py-4 font-medium text-right">จำนวนเงิน</th>
                                    <th class="px-6 py-4 font-medium text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($payoutRequests as $request)
                                <tr class="hover:bg-white/[0.01] transition">
                                    <td class="px-6 py-4">
                                        <div class="text-white">{{ $request->created_at->format('d M Y') }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $request->created_at->format('H:i') }} น.</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 max-w-[200px] truncate">
                                        {{ $request->bank_account_details }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-white">
                                        ฿{{ number_format($request->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($request->status === 'pending')
                                            <span class="px-3 py-1 rounded-full bg-yellow-500/10 text-yellow-500 text-[10px] font-bold">รอดำเนินการ</span>
                                        @elseif($request->status === 'approved')
                                            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 text-[10px] font-bold">อนุมัติแล้ว</span>
                                        @elseif($request->status === 'paid')
                                            <span class="px-3 py-1 rounded-full bg-green-500/10 text-green-500 text-[10px] font-bold">โอนสำเร็จ</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-[10px] font-bold">ปฏิเสธ</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                                        ไม่พบประวัติการถอนเงินในขณะนี้
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-white/5">
                        {{ $payoutRequests->links() }}
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>