<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>จอง {{ $studio->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

    <div class="max-w-xl mx-auto py-14 px-4">

        <a href="{{ route('customer.explore.index') }}"
            class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold mb-6 transition">
            ← กลับหน้า Explore
        </a>


        <h1 class="text-2xl font-bold mb-8">
            จอง {{ $studio->name }}
        </h1>

        <form method="POST"
            action="{{ route('customer.bookings.store', $studio->id) }}"
            class="bg-[#111C33] p-8 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 space-y-6">

            @csrf

            {{-- วันที่ --}}
            <div>
                <label class="block mb-2 text-sm text-blue-300/70">
                    วันที่
                </label>
                <input type="date"
                    name="date"
                    required
                    class="w-full bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-blue-300 focus:outline-none focus:border-blue-500">
            </div>

            {{-- เวลาเริ่ม --}}
            <div>
                <label class="block mb-2 text-sm text-blue-300/70">
                    เวลาเริ่ม
                </label>
                <input type="time"
                    name="start_time"
                    required
                    class="w-full bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-blue-300 focus:outline-none focus:border-blue-500">
            </div>

            {{-- เวลาสิ้นสุด --}}
            <div>
                <label class="block mb-2 text-sm text-blue-300/70">
                    เวลาสิ้นสุด
                </label>
                <input type="time"
                    name="end_time"
                    required
                    class="w-full bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-blue-300 focus:outline-none focus:border-blue-500">
            </div>

            {{-- ปุ่ม --}}
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold shadow-md shadow-blue-900/30 transition">
                ยืนยันการจอง
            </button>

        </form>

    </div>

</body>

</html>