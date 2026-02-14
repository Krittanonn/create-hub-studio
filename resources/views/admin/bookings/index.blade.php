<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรายการจอง - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl">
            <h2 class="text-2xl font-bold mb-8 text-center text-blue-400">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">📊 Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-2.5 px-4 rounded bg-blue-600 shadow-lg">📅 การจอง</a>
                <a href="{{ route('admin.reviews.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">⭐ จัดการรีวิว</a>
                <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">👥 ผู้ใช้งาน</a>
                <hr class="border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-red-600">🚪 ออกจากระบบ</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">รายการการจองทั้งหมด</h1>
                    <p class="text-gray-500">ติดตามสถานะการจอง การชำระเงิน และข้อมูลการใช้บริการสตูดิโอ</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-4">ลูกค้า / สตูดิโอ</th>
                            <th class="px-6 py-4">วัน-เวลา</th>
                            <th class="px-6 py-4 text-center">ยอดรวม</th>
                            <th class="px-6 py-4 text-center">สถานะจอง</th>
                            <th class="px-6 py-4 text-center">การชำระเงิน</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <div class="text-xs text-blue-500 font-semibold">{{ $booking->studio->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div><i class="far fa-calendar-alt mr-1"></i> {{ $booking->start_time->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-900">
                                ฿{{ number_format($booking->total_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $statusClass = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($booking->payment_status === 'paid')
                                    <span class="text-green-600 text-xs font-bold uppercase italic border border-green-600 px-2 py-0.5 rounded">PAID</span>
                                @else
                                    <span class="text-gray-400 text-xs font-bold uppercase italic border border-gray-400 px-2 py-0.5 rounded">UNPAID</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                                    <i class="fas fa-eye mr-2"></i> รายละเอียด
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="far fa-calendar-times text-4xl mb-3 block"></i>
                                ไม่พบรายการจองในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        </main>
    </div>

</body>
</html>