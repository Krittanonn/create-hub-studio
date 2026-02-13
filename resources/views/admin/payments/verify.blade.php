<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Verify Payments - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen p-10">

    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
        <div class="flex items-center gap-6 mb-12">

            <a href="{{ route('admin.dashboard') }}"
                class="text-yellow-400 text-xl hover:underline">
                ←
            </a>

            <h1 class="text-3xl font-semibold">
                ตรวจสอบยอดโอนเงิน 🔔
            </h1>

        </div>


        <!-- LIST -->
        <div class="space-y-6">

            @forelse($pendingPayments ?? [] as $payment)

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-yellow-400/20 flex justify-between items-center">

                <div>
                    <p class="text-xs text-gray-500 mb-2">
                        Booking ID: #{{ $payment->booking_id }}
                    </p>

                    <h3 class="font-semibold text-xl text-yellow-400">
                        ฿{{ number_format($payment->amount, 2) }}
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        ลูกค้า: {{ $payment->booking->user->name }}
                    </p>
                </div>

                <div class="flex gap-3">

                    <button class="bg-[#0F1525] border border-white/10 px-4 py-2 rounded-xl text-sm font-medium hover:bg-white/5 transition">
                        ดูสลิป
                    </button>

                    <form action="{{ route('admin.payments.approve', $payment->id) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="bg-green-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-green-600 transition">
                            อนุมัติ
                        </button>
                    </form>

                </div>

            </div>

            @empty

            <div class="text-center py-24 bg-[#131A2E] rounded-2xl border border-dashed border-white/10 text-gray-500">
                ไม่มีสลิปที่ค้างตรวจสอบในขณะนี้
            </div>

            @endforelse

        </div>

    </div>

</body>

</html>