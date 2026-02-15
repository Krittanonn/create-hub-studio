<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>{{ $studio->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-5xl mx-auto py-14 px-4">

    <a href="{{ route('customer.explore.index') }}"
       class="text-blue-400 hover:text-blue-300 font-semibold mb-8 inline-block transition">
        ← กลับหน้า Explore
    </a>

    <div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 p-8">

        {{-- Studio Image --}}
        <div class="h-72 bg-[#0F1A2F] rounded-xl flex items-center justify-center mb-8 text-blue-300/40 text-sm">
            Studio Image
        </div>

        <h1 class="text-3xl font-bold mb-3 text-white">
            {{ $studio->name }}
        </h1>

        <p class="text-blue-300/60 mb-6">
            {{ $studio->location }}
        </p>

        <div class="text-blue-300/70 leading-relaxed mb-8">
            {{ $studio->description }}
        </div>

        <div class="flex items-center justify-between border-t border-blue-900/30 pt-6">

            <div class="text-2xl font-bold text-blue-400">
                ฿{{ number_format($studio->price_per_hour ?? $studio->base_price, 2) }}
                <span class="text-sm text-blue-300/60 font-normal">/ ชั่วโมง</span>
            </div>

            <a href="{{ route('customer.bookings.create', $studio->id) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold shadow-md shadow-blue-900/30 transition">
                จองเลย
            </a>

        </div>

    </div>

</div>

</body>
</html>
