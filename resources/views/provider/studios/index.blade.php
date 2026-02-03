<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สตูดิโอของฉัน - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 p-6 md:p-10">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('provider.dashboard') }}" class="text-indigo-600 text-sm font-bold">← กลับไป Dashboard</a>
                <h1 class="text-3xl font-bold mt-2">สตูดิโอของฉัน</h1>
            </div>
            <a href="{{ route('provider.studios.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                + เพิ่มสตูดิโอใหม่
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @forelse($studios ?? [] as $studio)
            <div class="bg-white rounded-2xl shadow-sm border p-2 flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-64 h-48 bg-gray-200 rounded-xl overflow-hidden shrink-0">
                    <img src="https://via.placeholder.com/400x300?text=Studio+Image" class="w-full h-full object-cover">
                </div>

                <div class="flex-1 p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $studio->name }}</h2>
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $studio->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $studio->status == 'active' ? 'เปิดใช้งาน' : 'รออนุมัติ' }}
                            </span>
                        </div>
                        <p class="text-gray-500 mt-1 text-sm">{{ $studio->location }}</p>
                        <p class="text-gray-400 mt-4 text-xs line-clamp-2">{{ $studio->description }}</p>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <span class="text-xl font-bold text-indigo-600">฿{{ number_format($studio->price_per_hour) }} <span class="text-sm text-gray-400">/ ชม.</span></span>
                        <div class="flex gap-2">
                            <a href="{{ route('provider.studios.edit', $studio->id) }}" class="px-4 py-2 border rounded-lg text-sm font-bold hover:bg-gray-50">แก้ไข</a>
                            <a href="{{ route('provider.availability.index', ['studio_id' => $studio->id]) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-bold hover:bg-gray-900">จัดการเวลาเปิด-ปิด</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed">
                <div class="text-6xl mb-4">🏠</div>
                <h3 class="text-xl font-bold text-gray-700">คุณยังไม่มีสตูดิโอในระบบ</h3>
                <p class="text-gray-400 mt-2">เริ่มสร้างรายได้โดยการเพิ่มสตูดิโอแห่งแรกของคุณ</p>
            </div>
            @endforelse
        </div>
    </div>

</body>
</html>