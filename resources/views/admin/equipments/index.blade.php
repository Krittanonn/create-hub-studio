<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>คลังอุปกรณ์ - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">
    @include('layouts.admin-sidebar')

    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-8">จัดการอุปกรณ์เช่า</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($equipments as $item)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-bold text-lg text-gray-800">{{ $item->name }}</h3>
                    <span class="text-sm font-bold text-indigo-600">{{ number_format($item->price_per_unit) }} ฿/ชิ้น</span>
                </div>
                
                <form action="{{ route('admin.equipments.updateStock', $item->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <label class="text-xs text-gray-400 uppercase font-bold">จำนวนคงเหลือในสต็อก</label>
                    <div class="flex mt-1 gap-2">
                        <input type="number" name="stock" value="{{ $item->stock }}" class="w-full border rounded px-3 py-1.5 focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-1.5 rounded hover:bg-black transition">อัปเดต</button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </main>
</body>
</html>