<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0F1A] text-white antialiased">

    <!-- ================= NAVBAR ================= -->
    <nav class="bg-black/40 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">

            <div class="flex items-center gap-2 text-lg font-semibold">
                <span class="text-yellow-400">📷</span>
                <span class="tracking-wide">CREATE HUB</span>
            </div>

            <div class="flex gap-8 items-center text-sm">

                <a class="text-gray-300 hover:text-white transition">Features</a>
                <a class="text-gray-300 hover:text-white transition">Pricing</a>
                <a class="text-gray-300 hover:text-white transition">About</a>

                @if (Route::has('login'))
                @auth
                <a href="{{ 
                        match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'provider' => route('provider.dashboard'),
                            default => route('customer.explore.index'),
                        } 
                    }}"
                    class="px-4 py-2 rounded-xl bg-yellow-500 text-black font-medium hover:bg-yellow-400 transition">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="px-4 py-2 rounded-xl border border-white/20 hover:bg-white/10 transition">
                    เข้าสู่ระบบ / Login
                </a>
                @endauth
                @endif

            </div>
        </div>
    </nav>

    <!-- ================= HERO ================= -->
    <section class="relative overflow-hidden">

        <!-- Glow Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-black to-black"></div>
        <div class="absolute top-1/3 left-1/3 w-[500px] h-[500px] bg-yellow-500/10 blur-[120px] rounded-full"></div>

        <div class="relative max-w-6xl mx-auto px-8 py-32 text-center">

            <div class="inline-block px-4 py-2 rounded-full border border-yellow-400/40 text-yellow-400 text-sm mb-8">
                ✨ All-in-One Studio Platform
            </div>

            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6 bg-gradient-to-r from-yellow-400 via-yellow-200 to-purple-400 text-transparent bg-clip-text">
                Create. Produce. Thrive.
            </h1>

            <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">
                ระบบจองสตูดิโอและอุปกรณ์ครบวงจร
                Platform for studio rental, equipment booking, staff hiring, and live production.
            </p>

            <div class="flex justify-center gap-6 flex-wrap">

                <a href="{{ route('customer.explore.index') }}"
                    class="px-8 py-4 rounded-xl bg-yellow-500 text-black font-semibold hover:bg-yellow-400 transition">
                    จองสตูดิโอ / Book Studio →
                </a>

                <a href="{{ route('register') }}?role=provider"
                    class="px-8 py-4 rounded-xl border border-white/20 hover:bg-white/10 transition">
                    ปล่อยเช่าสตูดิโอ / List Your Studio
                </a>

            </div>

        </div>

    </section>

    <!-- ================= FEATURES ================= -->
    <section class="bg-[#0F1525] py-24 border-t border-white/5">

        <div class="max-w-6xl mx-auto px-8 text-center">

            <h2 class="text-3xl font-bold mb-6">
                Platform Features
            </h2>

            <p class="text-gray-400 mb-16">
                ฟีเจอร์ครบครันสำหรับทุกความต้องการ
            </p>

            <div class="grid md:grid-cols-3 gap-10">

                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 hover:border-yellow-400/40 transition">
                    <div class="text-yellow-400 text-3xl mb-4">📸</div>
                    <h3 class="font-semibold mb-3">Studio Booking</h3>
                    <p class="text-gray-400 text-sm">
                        ค้นหาและจองสตูดิโอได้ง่ายในไม่กี่คลิก
                    </p>
                </div>

                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 hover:border-yellow-400/40 transition">
                    <div class="text-yellow-400 text-3xl mb-4">💡</div>
                    <h3 class="font-semibold mb-3">Equipment Rental</h3>
                    <p class="text-gray-400 text-sm">
                        เช่าอุปกรณ์เสริมพร้อมสตูดิโอได้ทันที
                    </p>
                </div>

                <div class="bg-[#131A2E] p-8 rounded-2xl border border-white/5 hover:border-yellow-400/40 transition">
                    <div class="text-yellow-400 text-3xl mb-4">👥</div>
                    <h3 class="font-semibold mb-3">Staff Hiring</h3>
                    <p class="text-gray-400 text-sm">
                        จองทีมงานมืออาชีพเพื่อช่วยให้งานคุณสมบูรณ์แบบ
                    </p>
                </div>

            </div>

        </div>

    </section>

    <footer class="py-10 text-center text-gray-500 text-sm border-t border-white/5">
        © 2026 Create Hub Studio
    </footer>

    <!-- ================= Mr.Pacman button ================= -->
    <a href="https://www.google.com/logos/2010/pacman10-i.html"
        target="_blank"
        class="fixed bottom-6 right-6 px-6 py-3 bg-yellow-500 text-black rounded-full font-semibold shadow-xl hover:bg-yellow-400 transition">
        🟡 Mr.Pac
    </a>

</body>

</html>