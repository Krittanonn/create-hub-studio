<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Verify Payments - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 font-bold text-xl">←</a>
            <h1 class="text-3xl font-bold">ตรวจสอบยอดโอนเงิน 🔔</h1>
        </div>

        <div class="space-y-4">
            @forelse($pendingPayments ?? [] as $payment)
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-400 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Booking ID: #{{ $payment->booking_id }}</p>
                    <h3 class="font-bold text-lg">ยอดโอน: ฿{{ number_format($payment->amount, 2) }}</h3>
                    <p class="text-sm text-gray-600">ลูกค้า: {{ $payment->booking->user->name }}</p>
                </div>
                <div class="flex gap-3">
                    <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg text-sm font-bold">ดูสลิป</button>
                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold">อนุมัติ</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-xl border-2 border-dashed">
                <p class="text-gray-400">ไม่มีสลิปที่ค้างตรวจสอบในขณะนี้</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>