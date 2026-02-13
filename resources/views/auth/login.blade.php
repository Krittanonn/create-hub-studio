<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen flex items-center justify-center relative overflow-hidden">

<!-- Glow Background -->
<div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-black to-black"></div>
<div class="absolute top-1/3 left-1/2 w-[500px] h-[500px] bg-yellow-500/10 blur-[120px] rounded-full"></div>

<div class="relative w-full max-w-md px-8">

    <!-- Logo -->
    <div class="text-center mb-10">
        <h1 class="text-3xl font-semibold tracking-wide">
            CREATE HUB
        </h1>
        <p class="text-gray-400 text-sm mt-2">
            เข้าสู่ระบบเพื่อเริ่มต้นสร้างสรรค์
        </p>
    </div>

    <!-- Card -->
    <div class="bg-[#131A2E] border border-white/10 rounded-2xl p-8 shadow-2xl">

        <h2 class="text-xl font-semibold mb-6 text-center">
            เข้าสู่ระบบ
        </h2>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/40 text-red-400 p-3 mb-6 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label class="block text-sm text-gray-400 mb-2">
                    อีเมล
                </label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 focus:ring-0 outline-none text-white placeholder-gray-500"
                >
            </div>

            <!-- Password -->
            <div class="mb-8">
                <label class="block text-sm text-gray-400 mb-2">
                    รหัสผ่าน
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 focus:border-yellow-400 focus:ring-0 outline-none text-white placeholder-gray-500"
                >
            </div>

            <!-- Button -->
            <button 
                type="submit" 
                class="w-full py-3 rounded-xl bg-yellow-500 text-black font-semibold hover:bg-yellow-400 transition">
                เข้าสู่ระบบ
            </button>

        </form>

        <!-- Register -->
        <p class="mt-6 text-center text-sm text-gray-400">
            ยังไม่มีบัญชี? 
            <a href="{{ route('register') }}" 
               class="text-yellow-400 hover:underline">
                สมัครสมาชิก
            </a>
        </p>

    </div>

</div>

</body>
</html>
