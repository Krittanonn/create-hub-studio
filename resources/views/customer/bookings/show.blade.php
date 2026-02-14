<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Booking Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto py-10 px-4">

    <div class="bg-white p-6 rounded shadow">

        <h1 class="text-2xl font-bold mb-4">
            {{ $booking->studio->name }}
        </h1>

        <p>วันที่: {{ $booking->date }}</p>
        <p>เวลา: {{ $booking->start_time }} - {{ $booking->end_time }}</p>
        <p>สถานะ: {{ $booking->status }}</p>
        <p class="mt-4 font-bold">
            ราคารวม: ฿{{ number_format($booking->total_price ?? 0, 2) }}
        </p>

        <a href="{{ route('customer.bookings.index') }}"
           class="text-blue-600 underline mt-4 inline-block">
            ← กลับ
        </a>

    </div>

</div>

</body>
</html>
