<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการทีมงาน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex min-h-screen text-sm">

    <aside class="w-64 bg-indigo-950 text-white flex-shrink-0 hidden md:flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-indigo-900 text-center"><span class="text-indigo-400">Create</span>Hub</div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('provider.dashboard') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">📊 Dashboard</a>
            <a href="{{ route('provider.studios.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">🏠 สตูดิโอของฉัน</a>
            <a href="{{ route('provider.equipments.index') }}" class="flex items-center gap-3 p-3 hover:bg-indigo-900 rounded-lg">💡 อุปกรณ์เช่า</a>
            <a href="{{ route('provider.staffs.index') }}" class="flex items-center gap-3 p-3 bg-indigo-800 rounded-lg">👨‍💼 ทีมงาน / Staff</a>
            <hr class="border-indigo-900">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="w-full text-left p-3 text-red-400">🚪 ออกจากระบบ</button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-8 lg:p-12">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold text-gray-800">จัดการทีมงาน 👨‍💼</h1>
                <a href="{{ route('provider.staffs.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                    + เพิ่มทีมงาน
                </a>
            </div>

            <div class="space-y-4">
                @forelse($staffs ?? [] as $staff)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-24 h-24 bg-indigo-50 rounded-2xl flex items-center justify-center text-4xl shrink-0">👤</div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-xl font-bold text-gray-800">{{ $staff->name }}</h4>
                        <p class="text-indigo-500 font-bold text-xs uppercase tracking-widest mt-1">{{ $staff->position ?? 'Professional Staff' }}</p>
                        <p class="text-gray-400 mt-2 italic line-clamp-1">"{{ $staff->description }}"</p>
                    </div>
                    <div class="text-center md:text-right px-8 border-x md:border-x-0 md:border-l border-gray-100">
                        <p class="text-xs text-gray-400 uppercase font-bold">อัตราค่าจ้าง</p>
                        <p class="text-2xl font-bold text-gray-800">฿{{ number_format($staff->price_per_hour) }}</p>
                        <p class="text-[10px] text-gray-400">/ ชั่วโมง</p>
                    </div>
                    <div class="flex md:flex-col gap-2">
                        <a href="{{ route('provider.staffs.edit', $staff->id) }}" class="p-3 bg-gray-50 text-indigo-600 rounded-xl hover:bg-indigo-50 transition border">✏️ แก้ไข</a>
                        <form action="{{ route('provider.staffs.destroy', $staff->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-3 bg-gray-50 text-red-500 rounded-xl hover:bg-red-50 transition border" onclick="return confirm('ต้องการลบข้อมูลสตาฟฟ์ใช่ไหม?')">🗑️ ลบ</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200 text-gray-400 italic">
                    <p class="text-5xl mb-4">🕴️</p>
                    ยังไม่มีทีมงานในสตูดิโอของคุณ
                </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>