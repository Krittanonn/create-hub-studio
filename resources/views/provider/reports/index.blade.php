<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Report - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen">

    <!-- HEADER -->
    <nav class="bg-[#0F1525] border-b border-white/5 p-5 px-10 flex justify-between items-center">

        <div class="flex items-center gap-4">
            <a href="{{ route('provider.dashboard') }}"
                class="text-yellow-400 font-medium hover:underline">
                ← Dashboard
            </a>

            <h1 class="text-xl font-semibold border-l border-white/10 pl-4">
                รายงานสรุปธุรกิจ
            </h1>
        </div>

        <div class="flex gap-3">
            <button class="bg-[#131A2E] border border-white/10 px-4 py-2 rounded-xl text-sm hover:bg-white/5 transition">
                PDF Report
            </button>

            <button class="bg-yellow-500 text-black px-4 py-2 rounded-xl text-sm font-semibold hover:bg-yellow-400 transition">
                Export Excel
            </button>
        </div>

    </nav>


    <main class="max-w-6xl mx-auto p-10">

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-xs uppercase mb-3">รายได้เดือนนี้</p>
                <h3 class="text-3xl font-bold text-yellow-400 font-mono">
                    ฿{{ number_format($monthlyRevenue ?? 0) }}
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-xs uppercase mb-3">จำนวนบุ๊คกิ้ง</p>
                <h3 class="text-3xl font-bold">
                    {{ $bookingCount ?? 0 }} รายการ
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-xs uppercase mb-3">คนเข้าชมหน้าโปรไฟล์</p>
                <h3 class="text-3xl font-bold text-yellow-400">
                    1.2K
                </h3>
            </div>

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">
                <p class="text-gray-500 text-xs uppercase mb-3">อัตราการยกเลิก</p>
                <h3 class="text-3xl font-bold text-red-400">
                    2.5%
                </h3>
            </div>

        </div>


        <!-- TABLE -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="font-semibold">
                    รายการรายรับแยกตามสตูดิโอ
                </h3>

                <span class="text-xs text-gray-500 italic">
                    อัปเดตล่าสุด: {{ now()->format('H:i') }} น.
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="text-gray-500 uppercase text-xs border-b border-white/5">
                        <tr>
                            <th class="p-6">ชื่อสตูดิโอ</th>
                            <th class="p-6 text-center">จองแล้ว (ครั้ง)</th>
                            <th class="p-6 text-right">ยอดเงินรวม</th>
                            <th class="p-6 text-center">ความนิยม</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($studioReports ?? [] as $report)

                        <tr class="border-b border-white/5 hover:bg-white/5 transition">

                            <td class="p-6 font-semibold">
                                {{ $report->name }}
                            </td>

                            <td class="p-6 text-center text-gray-400">
                                {{ $report->bookings_count }}
                            </td>

                            <td class="p-6 text-right font-semibold text-yellow-400">
                                ฿{{ number_format($report->total_revenue) }}
                            </td>

                            <td class="p-6">
                                <<div class="bg-yellow-400 h-full"
                                    style="width: 60%;">
            </div>

        </div>
        </td>

        </tr>

        @empty

        <tr>
            <td colspan="4"
                class="p-12 text-center text-gray-500 italic">
                ยังไม่มีข้อมูลการเงินในขณะนี้
            </td>
        </tr>

        @endforelse

        </tbody>

        </table>
        </div>

        </div>

    </main>

</body>

</html>