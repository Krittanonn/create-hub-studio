<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการการเงิน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-indigo-900 text-white p-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('provider.dashboard') }}" class="text-2xl hover:opacity-80">←</a>
                <h1 class="text-xl font-bold">การเงินและการถอนเงิน</h1>
            </div>
            <div class="text-sm opacity-80">ผู้ให้บริการ: {{ auth()->user()->name }}</div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 md:p-10">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="md:col-span-2 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-indigo-100 mb-2 font-medium uppercase tracking-wider text-sm">ยอดเงินที่ถอนได้ปัจจุบัน</p>
                    <h2 class="text-5xl font-extrabold mb-6">฿{{ number_format($balance ?? 0, 2) }}</h2>
                    
                    <form action="{{ route('provider.payouts.request') }}" method="POST">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-4">
                            <input type="number" name="amount" placeholder="ระบุจำนวนเงิน" 
                                   class="bg-white/20 border border-white/30 rounded-xl px-4 py-3 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 w-full sm:w-64"
                                   max="{{ $balance ?? 0 }}" required>
                            <button type="submit" class="bg-white text-indigo-700 px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-100 transition-all active:scale-95">
                                ส่งคำขอถอนเงิน
                            </button>
                        </div>
                    </form>
                </div>
                <div class="absolute -right-10 -bottom-10 text-[12rem] text-white opacity-10 rotate-12">💰</div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm flex flex-col justify-center text-center">
                <p class="text-gray-400 font-bold uppercase text-xs mb-2 tracking-widest">ยอดเงินรอคิวตรวจสอบ</p>
                <h3 class="text-3xl font-bold text-gray-700">฿{{ number_format($pendingAmount ?? 0, 2) }}</h3>
                <div class="mt-4 text-[10px] text-orange-500 font-medium bg-orange-50 py-1 px-3 rounded-full inline-block mx-auto">
                    อยู่ระหว่างการดำเนินการโดย Admin
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-700 text-lg">ประวัติการถอนเงิน</h3>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4.5h18M3 9.5h18M3 14.5h18M3 19.5h18"/></svg>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-400 font-bold uppercase text-[10px] tracking-widest">
                        <tr>
                            <th class="p-6">วันที่ส่งคำขอ</th>
                            <th class="p-6">รหัสอ้างอิง</th>
                            <th class="p-6 text-right">จำนวนเงิน</th>
                            <th class="p-6 text-center">สถานะ</th>
                            <th class="p-6 text-center">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($payoutRequests ?? [] as $payout)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-6 text-sm text-gray-600">{{ $payout->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-6 font-mono text-xs text-gray-400">#PY-{{ str_pad($payout->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="p-6 text-right font-bold text-gray-700">฿{{ number_format($payout->amount, 2) }}</td>
                            <td class="p-6 text-center">
                                @if($payout->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">กำลังตรวจสอบ</span>
                                @elseif($payout->status == 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">โอนสำเร็จ</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">ปฏิเสธ</span>
                                @endif
                            </td>
                            <td class="p-6 text-center text-xs text-gray-400 italic">
                                {{ $payout->admin_note ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center text-gray-400 italic">
                                <div class="mb-4 text-4xl">📄</div>
                                ยังไม่มีประวัติการถอนเงินในขณะนี้
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl p-6 flex gap-4 items-start">
            <span class="text-blue-500 text-xl">💡</span>
            <div class="text-sm text-blue-800">
                <h4 class="font-bold mb-1 text-blue-900">เงื่อนไขการรับเงิน</h4>
                <ul class="list-disc list-inside space-y-1 opacity-80">
                    <li>ยอดเงินที่ถอนได้จะคำนวณจากรายการจองที่ลูกค้า "เข้าใช้งานแล้ว" และ "ยืนยันการรับบริการ" เท่านั้น</li>
                    <li>Admin จะดำเนินการโอนเงินให้ภายใน 1-3 วันทำการหลังจากได้รับคำขอ</li>
                    <li>กรุณาตรวจสอบชื่อบัญชีและเลขที่บัญชีในโปรไฟล์ให้ถูกต้องก่อนกดถอน</li>
                </ul>
            </div>
        </div>
    </main>

</body>
</html>