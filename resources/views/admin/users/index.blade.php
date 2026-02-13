<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Manage Users - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen p-10">

    <div class="max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="flex items-center gap-6 mb-10">

            <a href="{{ route('admin.dashboard') }}"
                class="text-yellow-400 hover:underline text-sm">
                ← กลับหน้าหลัก
            </a>

            <h1 class="text-2xl font-semibold">
                จัดการผู้ใช้งานในระบบ
            </h1>

        </div>


        <!-- TABLE CARD -->
        <div class="bg-[#131A2E] rounded-2xl border border-white/5 overflow-hidden">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-white/5 text-gray-400">
                    <tr>
                        <th class="p-5">ชื่อ</th>
                        <th class="p-5">อีเมล</th>
                        <th class="p-5">บทบาท</th>
                        <th class="p-5">วันที่สมัคร</th>
                        <th class="p-5">จัดการ</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users ?? [] as $user)

                    <tr class="border-b border-white/5 hover:bg-white/5 transition">

                        <td class="p-5 font-medium">
                            {{ $user->name }}
                        </td>

                        <td class="p-5 text-gray-400">
                            {{ $user->email }}
                        </td>

                        <td class="p-5">

                            <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $user->role == 'admin'
                                ? 'bg-yellow-500/20 text-yellow-400'
                                : ($user->role == 'provider'
                                    ? 'bg-green-500/20 text-green-400'
                                    : 'bg-white/10 text-gray-400') }}">
                                {{ $user->role }}
                            </span>

                        </td>

                        <td class="p-5 text-gray-400">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <td class="p-5">
                            <button class="text-red-400 hover:text-red-300 text-sm font-medium transition">
                                ระงับสิทธิ์
                            </button>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="p-12 text-center text-gray-500">
                            ไม่พบรายชื่อผู้ใช้งาน
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>