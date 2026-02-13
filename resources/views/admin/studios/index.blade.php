<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Manage Studios - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen p-10">

    <div class="max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="flex items-center gap-6 mb-10">

            <a href="{{ route('admin.dashboard') }}"
                class="text-yellow-400 hover:underline text-sm">
                ← กลับ
            </a>

            <h1 class="text-2xl font-semibold">
                จัดการสตูดิโอทั้งหมด
            </h1>

        </div>


        <!-- TABLE CARD -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-white/5 text-gray-400">
                    <tr>
                        <th class="p-5">รูปภาพ</th>
                        <th class="p-5">ชื่อสตูดิโอ</th>
                        <th class="p-5">เจ้าของ</th>
                        <th class="p-5">สถานะ</th>
                        <th class="p-5">จัดการ</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($studios ?? [] as $studio)

                    <tr class="border-b border-white/5 hover:bg-white/5 transition">

                        <td class="p-5">
                            <div class="w-16 h-10 bg-[#0F1525] rounded border border-white/10"></div>
                        </td>

                        <td class="p-5 font-semibold">
                            {{ $studio->name }}
                        </td>

                        <td class="p-5 text-gray-400">
                            {{ $studio->user->name ?? 'ไม่ระบุ' }}
                        </td>

                        <td class="p-5">
                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">
                                รอการตรวจสอบ
                            </span>
                        </td>

                        <td class="p-5 flex gap-3">

                            <button class="bg-green-500 text-white px-4 py-1 rounded-xl text-xs font-medium hover:bg-green-600 transition">
                                อนุมัติ
                            </button>

                            <button class="bg-red-500/20 text-red-400 px-4 py-1 rounded-xl text-xs font-medium hover:bg-red-500 hover:text-white transition">
                                ปิดชั่วคราว
                            </button>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="p-14 text-center text-gray-500">
                            ยังไม่มีสตูดิโอในระบบ
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>