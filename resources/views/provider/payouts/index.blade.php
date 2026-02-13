<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการการเงิน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen">

    <!-- HEADER -->
    <nav class="bg-[#0F1525] border-b border-white/5 p-5">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('provider.dashboard') }}"
                    class="text-yellow-400 text-lg hover:underline">
                    ←
                </a>
                <h1 class="text-xl font-semibold">
                    การเงินและการถอนเงิน
                </h1>
            </div>
            <div class="text-sm text-gray-400">
                ผู้ให้บริการ: {{ auth()->user()->name }}
            </div>
        </div>
    </nav>


    <main class="max-w-6xl mx-auto p-6 md:p-10">

        <!-- BALANCE SECTION -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

            <!-- MAIN BALANCE -->
            <div class="md:col-span-2 bg-[#131A2E] rounded-2xl p-8 border border-white/5 relative overflow-hidden">

                <p class="text-gray-500 mb-3 text-sm uppercase tracking-wider">
                    ยอดเงินที่ถอนได้ปัจจุบัน
                </p>

                <h2 class="text-5xl font-bold text-yellow-400 mb-8">
                    ฿{{ number_format($balance ?? 0, 2) }}
                </h2>

                <form action="{{ route('provider.payouts.request') }}" method="POST">
                    @csrf

                    <div class="flex flex-col sm:flex-row gap-4">

                        <input type="number"
                            name="amount"
                            placeholder="ระบุจำนวนเงิน"
                            max="{{ $balance ?? 0 }}"
                            required
                            class="bg-[#0F1525] border border-white/10 rounded-xl px-4 py-3 text-sm focus:border-yellow-400 outline-none w-full sm:w-64">

                        <button type="submit"
                            class="bg-yellow-500 text-black px-8 py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
                            ส่งคำขอถอนเงิน
                        </button>

                    </div>
                </form>

                <div class="absolute -right-10 -bottom-10 text-[10rem] text-yellow-500 opacity-10 rotate-12">
                    💰
                </div>

            </div>

            <!-- PENDING BALANCE -->
            <div class="bg-[#131A2E] rounded-2xl p-8 border border-yellow-400/20 text-center">

                <p class="text-gray-500 uppercase text-xs mb-3 tracking-wider">
                    ยอดเงินรอคิวตรวจสอบ
                </p>

                <h3 class="text-3xl font-bold text-yellow-400">
                    ฿{{ number_format($pendingAmount ?? 0, 2) }}
                </h3>

                <div class="mt-5 text-xs text-yellow-400 bg-yellow-500/10 py-2 px-4 rounded-full inline-block">
                    อยู่ระหว่างการดำเนินการโดย Admin
                </div>

            </div>

        </div>


        <!-- HISTORY TABLE -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="font-semibold text-lg">
                    ประวัติการถอนเงิน
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="text-gray-500 uppercase text-xs border-b border-white/5">
                        <tr>
                            <th class="p-6">วันที่ส่งคำขอ</th>
                            <th class="p-6">รหัสอ้างอิง</th>
                            <th class="p-6 text-right">จำนวนเงิน</th>
                            <th class="p-6 text-center">สถานะ</th>
                            <th class="p-6 text-center">หมายเหตุ</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($payoutRequests ?? [] as $payout)

                        <tr class="border-b border-white/5 hover:bg-white/5 transition">

                            <td class="p-6 text-gray-400">
                                {{ $payout->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="p-6 font-mono text-xs text-gray-500">
                                #PY-{{ str_pad($payout->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="p-6 text-right font-semibold text-yellow-400">
                                ฿{{ number_format($payout->amount, 2) }}
                            </td>

                            <td class="p-6 text-center">

                                @if($payout->status == 'pending')
                                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs uppercase">
                                    กำลังตรวจสอบ
                                </span>
                                @elseif($payout->status == 'completed')
                                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs uppercase">
                                    โอนสำเร็จ
                                </span>
                                @else
                                <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs uppercase">
                                    ปฏิเสธ
                                </span>
                                @endif

                            </td>

                            <td class="p-6 text-center text-gray-500 text-xs italic">
                                {{ $payout->admin_note ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5"
                                class="p-16 text-center text-gray-500 italic">
                                <div class="mb-4 text-4xl text-yellow-400">📄</div>
                                ยังไม่มีประวัติการถอนเงินในขณะนี้
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>


        <!-- INFO BOX -->
        <div class="mt-10 bg-yellow-500/10 border border-yellow-400/30 rounded-2xl p-6 flex gap-4">

            <span class="text-yellow-400 text-xl">💡</span>

            <div class="text-sm text-gray-300">
                <h4 class="font-semibold mb-2 text-yellow-400">
                    เงื่อนไขการรับเงิน
                </h4>

                <ul class="list-disc list-inside space-y-1">
                    <li>ยอดเงินที่ถอนได้จะคำนวณจากรายการจองที่ลูกค้าเข้าใช้งานแล้วเท่านั้น</li>
                    <li>Admin จะดำเนินการโอนเงินภายใน 1-3 วันทำการ</li>
                    <li>กรุณาตรวจสอบข้อมูลบัญชีให้ถูกต้องก่อนกดถอน</li>
                </ul>
            </div>

        </div>

    </main>

</body>

</html>