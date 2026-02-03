<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รีวิวและเสียงตอบรับ - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Kanit', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-indigo-900 text-white p-4">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="{{ route('provider.dashboard') }}" class="hover:underline">← Dashboard</a>
            <h1 class="text-xl font-bold">รีวิวจากลูกค้า</h1>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-8">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-bold text-gray-800">4.8 <span class="text-xl text-orange-400">★</span></h2>
                <p class="text-gray-400 text-sm font-medium uppercase tracking-widest mt-1">คะแนนรีวิวเฉลี่ยของคุณ</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">จากทั้งหมด <strong>{{ count($reviews ?? []) }}</strong> ความคิดเห็น</p>
            </div>
        </div>

        <div class="space-y-6">
            @forelse($reviews ?? [] as $review)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-3 items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $review->user->name }}</h4>
                            <p class="text-[10px] text-gray-400">{{ $review->created_at->format('d/m/Y') }} • จองสตูดิโอ: {{ $review->studio->name }}</p>
                        </div>
                    </div>
                    <div class="text-orange-400 font-bold">
                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                    </div>
                </div>
                <p class="text-gray-700 text-sm leading-relaxed bg-gray-50 p-4 rounded-2xl italic">
                    "{{ $review->comment }}"
                </p>
                
                @if($review->reply)
                <div class="mt-4 ml-8 p-4 bg-indigo-50 rounded-2xl border-l-4 border-indigo-300">
                    <p class="text-[10px] font-bold text-indigo-600 uppercase mb-1">การตอบกลับจากคุณ:</p>
                    <p class="text-sm text-indigo-800">{{ $review->reply }}</p>
                </div>
                @else
                <form action="{{ route('provider.reviews.reply', $review->id) }}" method="POST" class="mt-4 flex gap-2">
                    @csrf @method('PATCH')
                    <input type="text" name="reply" placeholder="เขียนข้อความตอบกลับ..." class="flex-1 text-sm border p-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold">ตอบกลับ</button>
                </form>
                @endif
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed text-gray-400">
                <p>ยังไม่มีรีวิวจากลูกค้าในขณะนี้</p>
            </div>
            @endforelse
        </div>
    </main>

</body>
</html>