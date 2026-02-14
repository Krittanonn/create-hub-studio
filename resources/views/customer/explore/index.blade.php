<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Explore Studios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-14">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold">
            Explore Studios
        </h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-red-900/30">
                Logout
            </button>
        </form>
    </div>

    {{-- Filter Section --}}
    <form method="GET"
          action="{{ route('customer.explore.index') }}"
          class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12 bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="ค้นหาชื่อสตูดิโอ..."
               class="bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-2 text-blue-300 focus:outline-none focus:border-blue-500">

        <input type="number"
               name="min_price"
               value="{{ request('min_price') }}"
               placeholder="ราคาต่ำสุด"
               class="bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-2 text-blue-300 focus:outline-none focus:border-blue-500">

        <input type="number"
               name="max_price"
               value="{{ request('max_price') }}"
               placeholder="ราคาสูงสุด"
               class="bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-2 text-blue-300 focus:outline-none focus:border-blue-500">

        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2 font-semibold transition shadow-md shadow-blue-900/30">
            ค้นหา
        </button>
    </form>

    {{-- Studio Grid --}}
    @if($studios->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @foreach($studios as $studio)
                <div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 hover:border-blue-500/40 hover:scale-[1.02] transition overflow-hidden">

                    {{-- Placeholder Image --}}
                    <div class="h-40 bg-[#0F1A2F] flex items-center justify-center text-blue-300/40 text-sm">
                        Studio Image
                    </div>

                    <div class="p-5">

                        <h2 class="text-lg font-semibold mb-2 text-white">
                            {{ $studio->name }}
                        </h2>

                        <p class="text-sm text-blue-300/60 mb-2">
                            {{ $studio->location }}
                        </p>

                        <p class="font-bold text-lg mb-5 text-blue-400">
                            ฿{{ number_format($studio->price_per_hour ?? $studio->base_price, 2) }}
                            <span class="text-xs text-blue-300/60">/ ชั่วโมง</span>
                        </p>

                        <div class="flex gap-3">

                            <a href="{{ route('customer.explore.show', $studio->id) }}"
                               class="w-1/2 text-center bg-blue-500/10 text-blue-400 py-2 rounded-xl text-sm font-semibold hover:bg-blue-600 hover:text-white transition">
                                ดูรายละเอียด
                            </a>

                            <a href="{{ route('customer.bookings.create', $studio->id) }}"
                               class="w-1/2 text-center bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-900/30">
                                จองเลย
                            </a>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-12 text-blue-300/70">
            {{ $studios->withQueryString()->links() }}
        </div>

    @else
        <div class="text-center py-24 text-blue-300/50 italic">
            ไม่พบสตูดิโอที่ค้นหา
        </div>
    @endif

</div>

</body>
</html>
