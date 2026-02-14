<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรีวิว - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl">
            <h2 class="text-2xl font-bold mb-8 text-center text-blue-400">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">📊 Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">📅 การจอง</a>
                <a href="{{ route('admin.reviews.index') }}" class="block py-2.5 px-4 rounded bg-blue-600 shadow-lg">⭐ จัดการรีวิว</a>
                <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">👥 ผู้ใช้งาน</a>
                <hr class="border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-red-600">🚪 ออกจากระบบ</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">จัดการรีวิวทั้งหมด</h1>
                    <p class="text-gray-500">ตรวจสอบและดูแลความเรียบร้อยของความคิดเห็นจากลูกค้า</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-4">ลูกค้า / สตูดิโอ</th>
                            <th class="px-6 py-4 text-center">คะแนน</th>
                            <th class="px-6 py-4">ความคิดเห็น</th>
                            <th class="px-6 py-4">การตอบกลับ</th>
                            <th class="px-6 py-4">วันที่</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                                <div class="text-xs text-blue-500 font-semibold">{{ $review->studio->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-400">({{ $review->rating }}/5)</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 max-w-xs truncate" title="{{ $review->comment }}">
                                    {{ $review->comment ?? 'ไม่มีข้อความ' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                @if($review->provider_reply)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        ตอบกลับแล้ว
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        ยังไม่ตอบ
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $review->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรีวิวนี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt"></i> ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="far fa-comment-dots text-4xl mb-3 block"></i>
                                ไม่พบข้อมูลรีวิวในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        </main>
    </div>

</body>
</html>