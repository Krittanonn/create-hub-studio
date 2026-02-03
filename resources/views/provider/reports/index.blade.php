<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Report - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white border-b p-4 px-10 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route('provider.dashboard') }}" class="text-indigo-600 font-bold">← Dashboard</a>
            <h1 class="text-xl font-bold border-l pl-4">รายงานสรุปธุรกิจ</h1>
        </div>
        <div class="flex gap-2">
            <button class="bg-white border px-4 py-2 rounded-xl text-sm font-bold">PDF Report</button>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg">Export Excel</button>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">รายได้เดือนนี้</p>
                <h3 class="text-3xl font-bold text-gray-800 font-mono">฿{{ number_format($monthlyRevenue ?? 0) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">จำนวนบุ๊คกิ้ง</p>
                <h3 class="text-3xl font-bold text-indigo-600">{{ $bookingCount ?? 0 }} รายการ</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">คนเข้าชมหน้าโปรไฟล์</p>
                <h3 class="text-3xl font-bold text-blue-500">1.2K</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">อัตราการยกเลิก</p>
                <h3 class="text-3xl font-bold text-red-400">2.5%</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-700">รายการรายรับแยกตามสตูดิโอ</h3>
                <span class="text-xs text-gray-400 italic">อัปเดตล่าสุด: {{ now()->format('H:i') }} น.</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <tr>
                            <th class="p-6">ชื่อสตูดิโอ</th>
                            <th class="p-6 text-center">จองแล้ว (ครั้ง)</th>
                            <th class="p-6 text-right">ยอดเงินรวม</th>
                            <th class="p-6 text-center">ความนิยม</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($studioReports ?? [] as $report)
                        <tr>
                            <td class="p-6 font-bold">{{ $report->name }}</td>
                            <td class="p-6 text-center">{{ $report->bookings_count }}</td>
                            <td class="p-6 text-right font-bold text-green-600">฿{{ number_format($report->total_revenue) }}</td>
                            <td class="p-6">
                                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-indigo-500 h-full" style="--popularity: {{ rand(20, 100) }}%; width: var(--popularity);"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">ยังไม่มีข้อมูลการเงินในขณะนี้</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>