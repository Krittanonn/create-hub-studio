<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <aside class="w-64 bg-indigo-950 text-white flex-shrink-0 hidden md:flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-indigo-900 text-center">
            <span class="text-indigo-400">Create</span>Hub
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">
            <p class="text-indigo-500 text-xs font-bold uppercase px-2 mb-2">Main</p>
            <a href="{{ route('provider.dashboard') }}" class="flex items-center gap-3 p-3 bg-indigo-800 rounded-lg">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('provider.bookings.index') }}" class="flex items-center justify-between p-3 hover:bg-indigo-900 rounded-lg transition">
                <span class="flex items-center gap-3">📅 รายการจอง</span>
                <span class="bg-orange-500 text-[10px] px-1.5 py-0.5 rounded-full text-white">5</span>
            </a>

            <p class="text-indigo-500 text-xs font-bold uppercase px-2 mt-6 mb-2">Management</p>
            <a href="{{ route('provider.studios.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>🏠</span> สตูดิโอของฉัน
            </a>
            <a href="{{ route('provider.equipments.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>💡</span> อุปกรณ์เช่า
            </a>
            <a href="{{ route('provider.staffs.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>👨‍💼</span> ทีมงาน / Staff
            </a>
            <a href="{{ route('provider.availability.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>🕒</span> จัดการตารางเวลา
            </a>

            <p class="text-indigo-500 text-xs font-bold uppercase px-2 mt-6 mb-2">Finances & Feedback</p>
            <a href="{{ route('provider.payouts.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition font-bold text-yellow-400">
                <span>💰</span> การเงิน / ถอนเงิน
            </a>
            <a href="{{ route('provider.reviews.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>⭐</span> รีวิวจากลูกค้า
            </a>
            <a href="{{ route('provider.reports.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg transition">
                <span>📈</span> รายงานสรุป
            </a>
        </nav>

        <div class="p-4 border-t border-indigo-900">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full p-3 text-red-400 hover:bg-red-950/30 rounded-lg transition">
                    <span>🚪</span> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">
        
        <header class="bg-white shadow-sm p-4 flex justify-between items-center px-8">
            <h2 class="text-lg font-bold text-gray-700">ยินดีต้อนรับกลับมา, {{ auth()->user()->name }} 👋</h2>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('welcome') }}" class="text-indigo-600 hover:underline">ไปหน้าแรกเว็บ</a>
                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600 border border-indigo-200">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <p class="text-gray-400 text-xs font-bold uppercase mb-1">ยอดเงินคงเหลือ</p>
                    <h3 class="text-3xl font-bold text-indigo-600">฿{{ number_format($balance ?? 0, 2) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-2 italic">* ยอดที่สามารถกดถอนได้ทันที</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs font-bold uppercase mb-1">จำนวนสตูดิโอ</p>
                    <h3 class="text-3xl font-bold">{{ $totalStudios ?? 0 }}</h3>
                    <a href="{{ route('provider.studios.index') }}" class="text-xs text-blue-500 hover:underline mt-2 inline-block">จัดการสตูดิโอของคุณ →</a>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs font-bold uppercase mb-1">รายการจองเดือนนี้</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $monthlyBookings ?? 0 }}</h3>
                    <p class="text-[10px] text-green-500 mt-2 font-bold">+12% จากเดือนที่แล้ว</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs font-bold uppercase mb-1">รีวิวเฉลี่ย</p>
                    <h3 class="text-3xl font-bold text-orange-400">4.9</h3>
                    <div class="text-xs mt-2 italic text-gray-400">จากทั้งหมด 24 รีวิว</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-sm">
                
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b flex justify-between items-center bg-white sticky top-0">
                        <h3 class="font-bold text-gray-700">รายการจองล่าสุดที่เข้ามา</h3>
                        <a href="{{ route('provider.bookings.index') }}" class="text-indigo-600 font-bold text-xs hover:underline">ดูทั้งหมด</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-[10px]">
                                <tr>
                                    <th class="p-4">สตูดิโอ</th>
                                    <th class="p-4">วันที่จอง</th>
                                    <th class="p-4">ลูกค้า</th>
                                    <th class="p-4">ยอดเงิน</th>
                                    <th class="p-4 text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentBookings ?? [] as $booking)
                                <tr class="hover:bg-gray-50 transition cursor-pointer">
                                    <td class="p-4 font-bold">{{ $booking->studio->name }}</td>
                                    <td class="p-4">{{ $booking->start_time->format('d/m/Y H:i') }}</td>
                                    <td class="p-4 text-gray-600">{{ $booking->user->name }}</td>
                                    <td class="p-4 font-bold text-indigo-600">฿{{ number_format($booking->total_price) }}</td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-yellow-100 text-yellow-700">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-400 italic">
                                        ยังไม่มีรายการจองเข้ามาในขณะนี้
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-indigo-600 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                        <div class="relative z-10">
                            <h4 class="font-bold text-lg mb-2">ลงทะเบียนสตูดิโอเพิ่ม</h4>
                            <p class="text-indigo-200 text-xs mb-6">ขยายธุรกิจของคุณด้วยการเพิ่มสตูดิโอใหม่เข้าไปในระบบ</p>
                            <a href="{{ route('provider.studios.create') }}" class="inline-block bg-white text-indigo-600 px-6 py-2 rounded-xl font-bold text-sm shadow hover:bg-gray-100 transition">
                                เริ่มเลย!
                            </a>
                        </div>
                        <div class="absolute -right-10 -bottom-10 text-9xl text-indigo-500 opacity-20 rotate-12 transition group-hover:rotate-0">🏠</div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-4">สถานะการถอนเงิน</h4>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-yellow-100 flex items-center justify-center rounded-lg">🕒</div>
                                <div>
                                    <p class="font-bold text-xs">รอการตรวจสอบ</p>
                                    <p class="text-[10px] text-gray-400">฿1,500.00 • 01/02/2026</p>
                                </div>
                            </div>
                            <hr>
                            <a href="{{ route('provider.payouts.index') }}" class="block text-center text-indigo-600 font-bold text-xs py-1 hover:underline">ดูประวัติการเงินทั้งหมด</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>