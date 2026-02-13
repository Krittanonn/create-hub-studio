<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สตูดิโอของฉัน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white p-6 md:p-10">

    <div class="max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-10">

            <div>
                <a href="{{ route('provider.dashboard') }}"
                    class="text-yellow-400 text-sm font-medium hover:underline">
                    ← กลับไป Dashboard
                </a>

                <h1 class="text-3xl font-semibold mt-3">
                    สตูดิโอของฉัน
                </h1>
            </div>

            <a href="{{ route('provider.studios.create') }}"
                class="bg-yellow-500 text-black px-6 py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
                + เพิ่มสตูดิโอใหม่
            </a>

        </div>


        <!-- LIST -->
        <div class="grid grid-cols-1 gap-8">

            @forelse($studios ?? [] as $studio)

            <div class="bg-[#131A2E] rounded-2xl border border-white/5 flex flex-col md:flex-row overflow-hidden hover:border-yellow-400/40 transition">

                <!-- IMAGE -->
                <div class="w-full md:w-64 h-52 bg-[#0F1525] shrink-0">
                    <img src="https://via.placeholder.com/400x300?text=Studio+Image"
                        class="w-full h-full object-cover">
                </div>

                <!-- CONTENT -->
                <div class="flex-1 p-6 flex flex-col justify-between">

                    <div>
                        <div class="flex justify-between items-start">

                            <h2 class="text-xl font-semibold">
                                {{ $studio->name }}
                            </h2>

                            <span class="px-3 py-1 text-xs rounded-full
                            {{ $studio->status == 'active'
                                ? 'bg-green-500/20 text-green-400'
                                : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $studio->status == 'active' ? 'เปิดใช้งาน' : 'รออนุมัติ' }}
                            </span>

                        </div>

                        <p class="text-gray-400 mt-2 text-sm">
                            {{ $studio->location }}
                        </p>

                        <p class="text-gray-500 mt-4 text-sm line-clamp-2">
                            {{ $studio->description }}
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-8">

                        <span class="text-xl font-bold text-yellow-400">
                            ฿{{ number_format($studio->price_per_hour) }}
                            <span class="text-sm text-gray-500">/ ชม.</span>
                        </span>

                        <div class="flex gap-3">

                            <a href="{{ route('provider.studios.edit', $studio->id) }}"
                                class="px-4 py-2 border border-white/10 rounded-lg text-sm hover:bg-white/5 transition">
                                แก้ไข
                            </a>

                            <a href="{{ route('provider.availability.index', ['studio_id' => $studio->id]) }}"
                                class="px-4 py-2 bg-yellow-500 text-black rounded-lg text-sm font-medium hover:bg-yellow-400 transition">
                                จัดการเวลา
                            </a>

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="bg-[#131A2E] rounded-2xl p-20 text-center border border-white/5">

                <div class="text-6xl mb-6 text-yellow-400">🏠</div>

                <h3 class="text-xl font-semibold">
                    คุณยังไม่มีสตูดิโอในระบบ
                </h3>

                <p class="text-gray-500 mt-3">
                    เริ่มสร้างรายได้โดยการเพิ่มสตูดิโอแห่งแรกของคุณ
                </p>

            </div>

            @endforelse

        </div>

    </div>

</body>

</html>