<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold mb-8">
        การจองของฉัน
    </h1>

    <div class="space-y-4">

        @forelse($bookings as $booking)
            <div class="bg-white p-6 rounded shadow">

                <h2 class="text-xl font-semibold mb-2">
                    {{ $booking->studio->name }}
                </h2>

                <p>
                    วันที่: {{ $booking->date }}
                </p>

                <p>
                    เวลา: {{ $booking->start_time }} - {{ $booking->end_time }}
                </p>

                <p class="font-bold mt-2">
                    สถานะ: {{ $booking->status }}
                </p>

                <a href="{{ route('customer.bookings.show', $booking->id) }}"
                   class="text-blue-600 underline mt-3 inline-block">
                    ดูรายละเอียด
                </a>

            </div>
        @empty
            <div class="text-gray-500">
                ยังไม่มีการจอง
            </div>
        @endforelse

    </div>

</div>

</body>
</html>
