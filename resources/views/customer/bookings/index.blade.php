<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-5xl mx-auto py-12 px-4">

    <h1 class="text-3xl font-bold mb-10">
        การจองของฉัน
    </h1>

    <div class="space-y-6">

        @forelse($bookings as $booking)
            <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 hover:border-blue-500/40 transition">

                <h2 class="text-xl font-semibold text-white mb-3">
                    {{ $booking->studio->name }}
                </h2>

                <div class="text-blue-300/70 text-sm space-y-1">
                    <p>
                        วันที่: {{ $booking->date }}
                    </p>

                    <p>
                        เวลา: {{ $booking->start_time }} - {{ $booking->end_time }}
                    </p>
                </div>

                <div class="mt-4 flex justify-between items-center">

                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest
                        {{ $booking->status == 'confirmed'
                            ? 'bg-green-500/20 text-green-400'
                            : ($booking->status == 'pending'
                                ? 'bg-yellow-500/20 text-yellow-400'
                                : 'bg-red-500/20 text-red-400') }}">
                        {{ $booking->status }}
                    </span>

                    <a href="{{ route('customer.bookings.show', $booking->id) }}"
                       class="text-blue-400 hover:text-blue-300 font-semibold text-sm transition">
                        ดูรายละเอียด →
                    </a>

                </div>

            </div>
        @empty
            <div class="text-blue-300/50 italic text-center py-20">
                ยังไม่มีการจอง
            </div>
        @endforelse

    </div>

</div>

</body>
</html>
