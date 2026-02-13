<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอุปกรณ์เช่า - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F1525] border-r border-white/5 hidden md:flex flex-col">

        <div class="p-6 text-xl font-semibold border-b border-white/5 text-center">
            <span class="text-yellow-400">CREATE</span> HUB
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="{{ route('provider.dashboard') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                📊 Dashboard
            </a>

            <a href="{{ route('provider.studios.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                🏠 สตูดิโอของฉัน
            </a>

            <a href="{{ route('provider.equipments.index') }}"
                class="block px-4 py-3 rounded-xl bg-yellow-500 text-black font-medium">
                💡 อุปกรณ์เช่า
            </a>

            <a href="{{ route('provider.staffs.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                👨‍💼 ทีมงาน / Staff
            </a>

        </nav>

        <div class="p-4 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full px-4 py-3 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                    🚪 ออกจากระบบ
                </button>
            </form>
        </div>

    </aside>


    <!-- MAIN -->
    <main class="flex-1 p-8 lg:p-12">

        <div class="max-w-6xl mx-auto">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">

                <div>
                    <h1 class="text-3xl font-semibold">
                        คลังอุปกรณ์เช่า 💡
                    </h1>
                    <p class="text-gray-500 text-sm mt-2">
                        จัดการไฟ กล้อง และพร็อพต่างๆ สำหรับบริการเสริม
                    </p>
                </div>

                <a href="{{ route('provider.equipments.create') }}"
                    class="bg-yellow-500 text-black px-6 py-3 rounded-2xl font-semibold hover:bg-yellow-400 transition">
                    + เพิ่มอุปกรณ์ใหม่
                </a>

            </div>


            <!-- GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                @forelse($equipments ?? [] as $item)

                <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden hover:border-yellow-400/40 transition">

                    <div class="h-40 bg-[#0F1525] flex items-center justify-center text-5xl border-b border-white/5">
                        📷
                    </div>

                    <div class="p-5">

                        <h4 class="font-semibold truncate">
                            {{ $item->name }}
                        </h4>

                        <div class="mt-3 flex justify-between items-center text-sm">
                            <span class="text-yellow-400 font-semibold text-lg">
                                ฿{{ number_format($item->price_per_unit) }}
                            </span>
                            <span class="text-gray-500">
                                สต็อก: {{ $item->stock }}
                            </span>
                        </div>

                        <div class="mt-5 pt-5 border-t border-white/5 flex gap-3">

                            <a href="{{ route('provider.equipments.edit', $item->id) }}"
                                class="flex-1 text-center py-2 text-xs font-semibold bg-[#0F1525] border border-white/10 rounded-xl hover:bg-white/5 transition">
                                แก้ไข
                            </a>

                            <form action="{{ route('provider.equipments.destroy', $item->id) }}"
                                method="POST"
                                class="flex-1">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="w-full py-2 text-xs font-semibold text-red-400 border border-red-500/20 rounded-xl hover:bg-red-500 hover:text-white transition"
                                    onclick="return confirm('ลบอุปกรณ์นี้หรือไม่?')">
                                    ลบ
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                @empty

                <div class="col-span-full py-24 text-center bg-[#131A2E] rounded-2xl border border-dashed border-white/10 text-gray-500 italic">
                    <p class="text-5xl mb-6 text-yellow-400">🔦</p>
                    ยังไม่มีอุปกรณ์ในคลังของคุณ
                </div>

                @endforelse

            </div>

        </div>

    </main>

</body>

</html>