<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl flex-shrink-0">
            <div class="mb-10 text-center">
                <h2 class="text-2xl font-bold text-blue-400">Create Hub</h2>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Admin Management</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl bg-blue-600 shadow-lg font-bold">
                    <i class="fas fa-chart-pie w-5"></i>
                    <span>แดชบอร์ด</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase px-4">ระบบจัดการ</p>
                </div>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span>รายการจอง</span>
                </a>

                <a href="{{ route('admin.studios.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                    <i class="fas fa-camera-retro w-5"></i>
                    <span>สตูดิโอ</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                    <i class="fas fa-user-shield w-5"></i>
                    <span>ผู้ใช้งาน</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase px-4">การเงิน</p>
                </div>

                <a href="{{ route('admin.payments.verify') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                    <i class="fas fa-receipt w-5"></i>
                    <span>ตรวจสอบยอดโอน</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                    <i class="fas fa-cog w-5"></i>
                    <span>ตั้งค่าระบบ</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="pt-10">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 py-3 px-4 w-full rounded-xl text-red-400 hover:bg-red-600 hover:text-white transition font-bold">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>ออกจากระบบ</span>
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">แดชบอร์ดสรุปผล</h1>
                    <p class="text-gray-500 italic">ยินดีต้อนรับกลับมา, ข้อมูลอัปเดตล่าสุด ณ วันนี้</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="far fa-calendar-alt mr-2 text-blue-500"></i> {{ date('d F Y') }}
                    </span>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 mb-4">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div class="text-sm text-gray-400 font-bold uppercase tracking-tight">รายได้สุทธิ (ยืนยันแล้ว)</div>
                    <div class="text-2xl font-black text-gray-800 mt-1">฿{{ number_format($totalRevenue, 2) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="text-sm text-gray-400 font-bold uppercase tracking-tight">สมาชิกทั้งหมด</div>
                    <div class="text-2xl font-black text-gray-800 mt-1">{{ number_format($totalUsers) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mb-4">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <div class="text-sm text-gray-400 font-bold uppercase tracking-tight">สตูดิโอในระบบ</div>
                    <div class="text-2xl font-black text-gray-800 mt-1">{{ number_format($totalStudios) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 border-l-4 border-l-red-500 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 mb-4">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                    <div class="text-sm text-red-400 font-bold uppercase tracking-tight">รอตรวจสอบชำระเงิน</div>
                    <div class="text-2xl font-black text-red-600 mt-1">{{ $pendingPayments }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-gray-800"><i class="fas fa-history mr-2 text-blue-500"></i>รายการจองล่าสุด</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs text-blue-600 font-black hover:underline uppercase">ดูรายการทั้งหมด</a>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4">สตูดิโอ</th>
                                <th class="px-6 py-4">ผู้จอง</th>
                                <th class="px-6 py-4">ยอดเงิน</th>
                                <th class="px-6 py-4 text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentBookings as $booking)
                            <tr class="text-sm hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $booking->studio->name }}</td>
                                <td class="px-6 py-4 text-gray-600 italic">{{ $booking->user->name }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">฿{{ number_format($booking->total_price, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter
                                        {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic text-sm">ยังไม่มีรายการจองในระบบ</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-5 border-b pb-2">เมนูจัดการด่วน</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.payments.verify') }}" class="group flex items-center justify-between p-4 rounded-xl bg-orange-50 text-orange-700 hover:bg-orange-600 hover:text-white transition duration-200 shadow-sm">
                                <div class="flex items-center font-bold text-sm">
                                    <i class="fas fa-check-double mr-3 group-hover:scale-110 transition"></i> ตรวจสอบสลิปเงินโอน
                                </div>
                                <span class="bg-orange-200 text-orange-800 text-[10px] px-2 py-1 rounded-md font-black">{{ $pendingPayments }}</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="group flex items-center p-4 rounded-xl bg-slate-50 text-slate-700 hover:bg-slate-700 hover:text-white transition duration-200 shadow-sm">
                                <div class="flex items-center font-bold text-sm">
                                    <i class="fas fa-user-lock mr-3 group-hover:scale-110 transition"></i> จัดการสิทธิ์ผู้ใช้งาน
                                </div>
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="group flex items-center p-4 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-700 hover:text-white transition duration-200 shadow-sm">
                                <div class="flex items-center font-bold text-sm">
                                    <i class="fas fa-chart-line mr-3 group-hover:scale-110 transition"></i> สรุปรายงานรายได้
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-600 to-indigo-800 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 text-white/10 group-hover:scale-110 transition duration-500">
                            <i class="fas fa-shield-alt fa-9x"></i>
                        </div>
                        <h4 class="font-black text-lg mb-2 relative z-10">Admin Security</h4>
                        <p class="text-blue-100 text-xs leading-relaxed relative z-10 mb-4 italic">ตรวจสอบความปลอดภัยและสถานะการทำงานของระบบได้จากส่วนการตั้งค่า</p>
                        <a href="{{ route('admin.settings.index') }}" class="inline-block px-4 py-2 bg-white text-blue-700 rounded-lg text-xs font-black shadow-md hover:bg-blue-50 transition relative z-10">
                            เข้าสู่การตั้งค่า
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>