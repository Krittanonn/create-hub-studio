<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Hub Studio - จองสตูดิโอและอุปกรณ์</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <nav class="bg-white border-b p-4 flex justify-between items-center shadow-sm">
        <div class="text-xl font-bold text-blue-600">Create Hub Studio</div>
        <div class="flex gap-4 items-center">
            @if (Route::has('login'))
                @auth
                    {{-- แสดงชื่อและปุ่มไป Dashboard ตาม Role --}}
                    <span class="text-sm text-gray-600">สวัสดี, {{ auth()->user()->name }}</span>
                    <a href="{{ 
                        match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'provider' => route('provider.dashboard'),
                            default => route('customer.explore.index'),
                        } 
                    }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                        ไปที่ Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-blue-600">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border border-blue-600 text-blue-600 px-4 py-1.5 rounded text-sm hover:bg-blue-50">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-20 text-center">
        <h1 class="text-5xl font-extrabold mb-6">ค้นหาและจองสตูดิโอที่ดีที่สุด</h1>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
            แหล่งรวมสตูดิโอถ่ายภาพ อุปกรณ์กองถ่าย และทีมงานมืออาชีพ ครบจบในที่เดียว
        </p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('customer.explore.index') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold shadow-lg hover:bg-blue-700 transition">
                เริ่มค้นหาสตูดิโอ
            </a>
            <a href="{{ route('register') }}?role=provider" class="bg-white border border-gray-300 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition">
                สำหรับเจ้าของสตูดิโอ
            </a>
        </div>
    </main>

    <section class="bg-white py-16 border-t">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div>
                <div class="text-4xl mb-4">📸</div>
                <h3 class="text-xl font-bold mb-2">สตูดิโอหลากหลาย</h3>
                <p class="text-gray-500">เลือกสตูดิโอที่ตรงใจคุณจากตัวเลือกมากมายทั่วประเทศ</p>
            </div>
            <div>
                <div class="text-4xl mb-4">💡</div>
                <h3 class="text-xl font-bold mb-2">อุปกรณ์ครบครัน</h3>
                <p class="text-gray-500">เช่าไฟ กล้อง และอุปกรณ์เสริมต่างๆ พร้อมการจองสตูดิโอ</p>
            </div>
            <div>
                <div class="text-4xl mb-4">👤</div>
                <h3 class="text-xl font-bold mb-2">ทีมงานมืออาชีพ</h3>
                <p class="text-gray-500">จองช่างภาพ สไตล์ลิสต์ หรือช่างไฟ เพื่อช่วยให้งานคุณราบรื่น</p>
            </div>
        </div>
    </section>

    <footer class="p-8 text-center text-gray-400 border-t">
        &copy; 2026 Create Hub Studio. All rights reserved.
    </footer>

</body>
</html>