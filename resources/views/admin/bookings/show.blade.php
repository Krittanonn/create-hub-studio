<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการจอง #{{ $booking->id }} - Admin Panel</title>
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
            <div class="mb-8">
                <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i> กลับไปหน้ารายการจอง
                </a>
                <div class="flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">รายละเอียดการจอง #{{ $booking->id }}</h1>
                        <p class="text-gray-500">จองเมื่อวันที่ {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="space-x-2">
                        <span class="px-4 py-2 rounded-lg font-semibold bg-blue-100 text-blue-800">
                            สถานะ: {{ strtoupper($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700">ข้อมูลสตูดิโอและเวลา</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">สตูดิโอ</p>
                                <p class="font-semibold text-lg">{{ $booking->studio->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">วันใช้บริการ</p>
                                <p class="font-semibold text-lg">{{ $booking->start_time->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">เวลาเริ่ม</p>
                                <p class="font-semibold text-blue-600">{{ $booking->start_time->format('H:i') }} น.</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">เวลาสิ้นสุด</p>
                                <p class="font-semibold text-blue-600">{{ $booking->end_time->format('H:i') }} น.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gray-50 border-b">
                            <h3 class="font-bold text-gray-700 text-lg">รายการบริการและอุปกรณ์เพิ่มเติม</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs text-gray-400 uppercase">
                                <tr>
                                    <th class="px-6 py-3">รายการ</th>
                                    <th class="px-6 py-3">ประเภท</th>
                                    <th class="px-6 py-3 text-center">จำนวน</th>
                                    <th class="px-6 py-3 text-right">ราคา/หน่วย</th>
                                    <th class="px-6 py-3 text-right">รวม</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">ค่าเช่าสตูดิโอ (ฐาน)</td>
                                    <td class="px-6 py-4 text-xs text-gray-400 italic">Studio</td>
                                    <td class="px-6 py-4 text-center">1</td>
                                    <td class="px-6 py-4 text-right">฿{{ number_format($booking->studio->price_per_hour, 2) }}</td>
                                    <td class="px-6 py-4 text-right">฿{{ number_format($booking->studio->price_per_hour, 2) }}</td>
                                </tr>
                                
                                @foreach($booking->items as $item)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $item->itemable->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-500 uppercase">
                                            {{ str_replace('App\Models\\', '', $item->itemable_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right">฿{{ number_format($item->price_at_time, 2) }}</td>
                                    <td class="px-6 py-4 text-right">฿{{ number_format($item->price_at_time * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-700 uppercase">ยอดรวมสุทธิ</td>
                                    <td class="px-6 py-4 text-right font-bold text-2xl text-blue-600">฿{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold mb-4 text-gray-700"><i class="fas fa-user-circle mr-2 text-blue-500"></i>ข้อมูลลูกค้า</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400">ชื่อ-นามสกุล</p>
                                <p class="font-medium">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">อีเมล</p>
                                <p class="font-medium text-blue-500">{{ $booking->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">เบอร์โทรศัพท์</p>
                                <p class="font-medium">{{ $booking->user->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold mb-4 text-gray-700"><i class="fas fa-credit-card mr-2 text-green-500"></i>สถานะการชำระเงิน</h3>
                        
                        <div class="text-center p-4 rounded-lg {{ $booking->payment_status === 'paid' ? 'bg-green-50' : 'bg-red-50' }} mb-4">
                            <p class="text-sm uppercase font-bold {{ $booking->payment_status === 'paid' ? 'text-green-700' : 'text-red-700' }}">
                                {{ $booking->payment_status === 'paid' ? 'ชำระเงินเรียบร้อยแล้ว' : 'ยังไม่ได้ชำระเงิน' }}
                            </p>
                        </div>

                        @if($booking->payment)
                        <div class="text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-400">วิธีชำระ:</span>
                                <span class="font-medium">{{ strtoupper($booking->payment->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">วัน-เวลาที่จ่าย:</span>
                                <span class="font-medium">{{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col space-y-2">
                        @if($booking->status === 'pending')
                        <button class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-200">
                            ยืนยันการจอง
                        </button>
                        @endif
                        <button class="w-full py-3 bg-white border border-red-200 text-red-600 hover:bg-red-50 font-bold rounded-xl transition">
                            ยกเลิกรายการจอง
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>