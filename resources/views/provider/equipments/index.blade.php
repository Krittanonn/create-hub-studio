<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอุปกรณ์เช่า - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <aside class="w-64 bg-indigo-950 text-white flex-shrink-0 hidden md:flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-indigo-900 text-center"><span class="text-indigo-400">Create</span>Hub</div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">
            <a href="{{ route('provider.dashboard') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">📊 Dashboard</a>
            <a href="{{ route('provider.studios.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">🏠 สตูดิโอของฉัน</a>
            <a href="{{ route('provider.equipments.index') }}" class="flex items-center gap-3 p-3 bg-indigo-800 rounded-lg">💡 อุปกรณ์เช่า</a>
            <a href="{{ route('provider.staffs.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">👨‍💼 ทีมงาน / Staff</a>
            <hr class="border-indigo-900">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="w-full text-left p-3 text-red-400">🚪 ออกจากระบบ</button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">คลังอุปกรณ์เช่า 💡</h1>
                    <p class="text-gray-500 text-sm mt-1">จัดการไฟ กล้อง และพร็อพต่างๆ สำหรับบริการเสริม</p>
                </div>
                <a href="{{ route('provider.equipments.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                    + เพิ่มอุปกรณ์ใหม่
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($equipments ?? [] as $item)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-40 bg-gray-100 flex items-center justify-center text-5xl">📷</div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 truncate">{{ $item->name }}</h4>
                        <div class="mt-2 flex justify-between items-center text-sm">
                            <span class="text-indigo-600 font-bold text-lg">฿{{ number_format($item->price_per_unit) }}</span>
                            <span class="text-gray-400 font-medium">สต็อก: {{ $item->stock }}</span>
                        </div>
                        <div class="mt-4 pt-4 border-t flex gap-2">
                            <a href="{{ route('provider.equipments.edit', $item->id) }}" class="flex-1 text-center py-2 text-xs font-bold bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-100 border">แก้ไข</a>
                            <form action="{{ route('provider.equipments.destroy', $item->id) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full py-2 text-xs font-bold text-red-500 border border-red-50 rounded-xl hover:bg-red-50" onclick="return confirm('ลบอุปกรณ์นี้หรือไม่?')">ลบ</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-24 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200 text-gray-400 italic">
                    <p class="text-5xl mb-4">🔦</p>
                    ยังไม่มีอุปกรณ์ในคลังของคุณ
                </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>