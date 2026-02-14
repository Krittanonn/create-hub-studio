<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>{{ $studio->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto py-10 px-4">

    <a href="{{ route('customer.explore.index') }}"
       class="text-blue-600 underline mb-6 inline-block">
        ← กลับหน้า Explore
    </a>

    <div class="bg-white rounded shadow p-6">

        <div class="h-64 bg-gray-200 flex items-center justify-center mb-6">
            Studio Image
        </div>

        <h1 class="text-3xl font-bold mb-2">
            {{ $studio->name }}
        </h1>

        <p class="text-gray-600 mb-4">
            {{ $studio->location }}
        </p>

        <p class="mb-6">
            {{ $studio->description }}
        </p>

        <div class="text-2xl font-bold mb-6">
            ฿{{ number_format($studio->price_per_hour ?? $studio->base_price, 2) }}
            / ชั่วโมง
        </div>

        <a href="{{ route('customer.bookings.create', $studio->id) }}"
           class="bg-blue-600 text-white px-6 py-3 rounded">
            จองเลย
        </a>

    </div>

</div>

</body>
</html>
