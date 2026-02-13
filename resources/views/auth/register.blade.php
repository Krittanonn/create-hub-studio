<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] min-h-screen flex items-center justify-center text-white">

<div class="w-full max-w-md">

    <div class="bg-[#131A2E] p-10 rounded-2xl border border-white/5 shadow-xl">

        <h2 class="text-2xl font-semibold text-center mb-8">
            สมัครสมาชิก
        </h2>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    ชื่อ-นามสกุล
                </label>
                <input type="text"
                       name="name"
                       required
                       class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    อีเมล
                </label>
                <input type="email"
                       name="email"
                       required
                       class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    รหัสผ่าน
                </label>
                <input type="password"
                       name="password"
                       required
                       class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    ยืนยันรหัสผ่าน
                </label>
                <input type="password"
                       name="password_confirmation"
                       required
                       class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 outline-none text-sm">
            </div>

            <!-- ROLE -->
            <div>
                <label class="block text-sm text-yellow-400 mb-3 font-medium">
                    สมัครสมาชิกในฐานะ:
                </label>

                <div class="flex gap-6 text-sm">

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio"
                               name="role"
                               value="customer"
                               checked
                               class="accent-yellow-400">
                        ลูกค้า
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio"
                               name="role"
                               value="provider"
                               class="accent-yellow-400">
                        เจ้าของสตูดิโอ
                    </label>

                </div>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-yellow-500 text-black py-3 rounded-xl font-semibold hover:bg-yellow-400 transition mt-4">
                สมัครสมาชิก
            </button>

        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            มีบัญชีอยู่แล้ว?
            <a href="{{ route('login') }}"
               class="text-yellow-400 hover:underline">
                เข้าสู่ระบบ
            </a>
        </p>

    </div>

</div>

</body>
</html>
