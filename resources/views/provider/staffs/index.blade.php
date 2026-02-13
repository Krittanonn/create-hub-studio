<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการทีมงาน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white flex min-h-screen text-sm">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F1525] border-r border-white/5 hidden md:flex flex-col">

        <div class="p-6 text-xl font-semibold border-b border-white/5 text-center">
            <span class="text-yellow-400">CREATE</span> HUB
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('provider.dashboard') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                📊 Dashboard
            </a>

            <a href="{{ route('provider.studios.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                🏠 สตูดิโอของฉัน
            </a>

            <a href="{{ route('provider.equipments.index') }}"
                class="block px-4 py-3 rounded-xl hover:bg-white/5 transition">
                💡 อุปกรณ์เช่า
            </a>

            <a href="{{ route('provider.staffs.index') }}"
                class="block px-4 py-3 rounded-xl bg-yellow-500 text-black font-medium">
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
    <main class="flex-1 p-10 lg:p-14">

        <div class="max-w-5xl mx-auto">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-12">

                <h1 class="text-3xl font-semibold">
                    จัดการทีมงาน 👨‍💼
                </h1>

                <a href="{{ route('provider.staffs.create') }}"
                    class="bg-yellow-500 text-black px-6 py-3 rounded-2xl font-semibold hover:bg-yellow-400 transition">
                    + เพิ่มทีมงาน
                </a>

            </div>


            <!-- LIST -->
            <div class="space-y-6">

                @forelse($staffs ?? [] as $staff)

                <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5 flex flex-col md:flex-row items-center gap-6 hover:border-yellow-400/40 transition">

                    <!-- ICON -->
                    <div class="w-24 h-24 bg-[#0F1525] rounded-2xl flex items-center justify-center text-4xl shrink-0 border border-white/10">
                        👤
                    </div>

                    <!-- INFO -->
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-xl font-semibold">
                            {{ $staff->name }}
                        </h4>

                        <p class="text-yellow-400 text-xs uppercase tracking-wider mt-2">
                            {{ $staff->position ?? 'Professional Staff' }}
                        </p>

                        <p class="text-gray-400 mt-3 text-sm italic line-clamp-1">
                            "{{ $staff->description }}"
                        </p>
                    </div>

                    <!-- PRICE -->
                    <div class="text-center md:text-right px-8 border-x border-white/5">

                        <p class="text-xs text-gray-500 uppercase">
                            อัตราค่าจ้าง
                        </p>

                        <p class="text-2xl font-bold text-yellow-400">
                            ฿{{ number_format($staff->price_per_hour) }}
                        </p>

                        <p class="text-xs text-gray-500">
                            / ชั่วโมง
                        </p>

                    </div>

                    <!-- ACTIONS -->
                    <div class="flex md:flex-col gap-3">

                        <a href="{{ route('provider.staffs.edit', $staff->id) }}"
                            class="px-4 py-2 border border-white/10 rounded-xl hover:bg-white/5 transition text-center">
                            ✏️ แก้ไข
                        </a>

                        <form action="{{ route('provider.staffs.destroy', $staff->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition w-full"
                                onclick="return confirm('ต้องการลบข้อมูลสตาฟฟ์ใช่ไหม?')">
                                🗑️ ลบ
                            </button>
                        </form>

                    </div>

                </div>

                @empty

                <div class="py-24 text-center bg-[#131A2E] rounded-2xl border border-dashed border-white/10 text-gray-500">

                    <p class="text-6xl mb-6 text-yellow-400">🕴️</p>

                    ยังไม่มีทีมงานในสตูดิโอของคุณ

                </div>

                @endforelse

            </div>

        </div>

    </main>

</body>

</html>