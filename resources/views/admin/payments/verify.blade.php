<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตรวจสอบยอดเงิน - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">
    @include('layouts.admin-sidebar')

    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-8">รายการรอตรวจสอบการโอนเงิน</h1>

        <div class="grid grid-cols-1 gap-6">
            @forelse($payments as $payment)
            <div class="bg-white p-6 rounded-2xl shadow-sm border flex items-center justify-between">
                <div class="flex gap-6 items-center">
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                    <div>
                        <p class="font-bold text-lg">ยอดโอน: ฿{{ number_format($payment->amount, 2) }}</p>
                        <p class="text-sm text-gray-500">ลูกค้า: {{ $payment->booking->user->name }}</p>
                        <p class="text-xs text-blue-500 font-bold">สตูดิโอ: {{ $payment->booking->studio->name }}</p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-700 transition">
                            ยืนยันยอดเงิน
                        </button>
                    </form>
                    <button class="bg-red-50 text-red-600 px-6 py-2 rounded-xl font-bold hover:bg-red-100">ปฏิเสธ</button>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-gray-400">
                <p>ไม่มีรายการค้างตรวจสอบในขณะนี้</p>
            </div>
            @endforelse
        </div>
    </main>
</body>
</html>