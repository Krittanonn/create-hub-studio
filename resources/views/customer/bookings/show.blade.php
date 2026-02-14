<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Booking Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-xl mx-auto py-14 px-4">

    <div class="bg-[#111C33] p-8 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">

        <h1 class="text-2xl font-bold mb-6 text-white">
            {{ $booking->studio->name }}
        </h1>

        <div class="space-y-2 text-blue-300/70 text-sm">

            <p>
                วันที่:
                <span class="text-white font-medium">
                    {{ $booking->date }}
                </span>
            </p>

            <p>
                เวลา:
                <span class="text-white font-medium">
                    {{ $booking->start_time }} - {{ $booking->end_time }}
                </span>
            </p>

            <p>
                สถานะ:
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest
                    {{ $booking->status == 'confirmed'
                        ? 'bg-green-500/20 text-green-400'
                        : ($booking->status == 'pending'
                            ? 'bg-yellow-500/20 text-yellow-400'
                            : 'bg-red-500/20 text-red-400') }}">
                    {{ $booking->status }}
                </span>
            </p>

        </div>

        <div class="mt-8 border-t border-blue-900/30 pt-6">
            <p class="text-lg font-bold text-blue-400">
                ราคารวม: ฿{{ number_format($booking->total_price ?? 0, 2) }}
            </p>
        </div>

        <a href="{{ route('customer.bookings.index') }}"
           class="inline-block mt-8 text-blue-400 hover:text-blue-300 font-semibold transition">
            ← กลับ
        </a>

    </div>

</div>

</body>
</html>
