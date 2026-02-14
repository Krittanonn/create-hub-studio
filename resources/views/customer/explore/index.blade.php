<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Explore Studios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-bold mb-8 text-center">
            Explore Studios
        </h1>

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                Logout
            </button>
        </form>

        {{-- Filter Section --}}
        <form method="GET"
              action="{{ route('customer.explore.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10 bg-white p-6 rounded shadow">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="ค้นหาชื่อสตูดิโอ..."
                   class="border rounded px-3 py-2 w-full">

            <input type="number"
                   name="min_price"
                   value="{{ request('min_price') }}"
                   placeholder="ราคาต่ำสุด"
                   class="border rounded px-3 py-2 w-full">

            <input type="number"
                   name="max_price"
                   value="{{ request('max_price') }}"
                   placeholder="ราคาสูงสุด"
                   class="border rounded px-3 py-2 w-full">

            <button class="bg-black text-white rounded px-4 py-2">
                ค้นหา
            </button>
        </form>

        {{-- Studio Grid --}}
        @if($studios->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach($studios as $studio)
                    <div class="bg-white rounded shadow hover:shadow-xl transition overflow-hidden">

                        {{-- Placeholder Image --}}
                        <div class="h-40 bg-gray-200 flex items-center justify-center text-gray-400">
                            Studio Image
                        </div>

                        <div class="p-4">

                            <h2 class="text-lg font-semibold mb-2">
                                {{ $studio->name }}
                            </h2>

                            <p class="text-sm text-gray-600 mb-2">
                                {{ $studio->location }}
                            </p>

                            <p class="font-bold text-lg mb-4">
                                ฿{{ number_format($studio->price_per_hour ?? $studio->base_price, 2) }}
                                / ชั่วโมง
                            </p>

                            <div class="flex gap-2">

                                <a href="{{ route('customer.explore.show', $studio->id) }}"
                                   class="w-1/2 text-center bg-gray-200 py-2 rounded text-sm">
                                    ดูรายละเอียด
                                </a>

                                <a href="{{ route('customer.bookings.create', $studio->id) }}"
                                   class="w-1/2 text-center bg-blue-600 text-white py-2 rounded text-sm">
                                    จองเลย
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $studios->withQueryString()->links() }}
            </div>

        @else
            <div class="text-center py-20 text-gray-500">
                ไม่พบสตูดิโอที่ค้นหา
            </div>
        @endif

    </div>

</body>
</html>
