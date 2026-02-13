<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รีวิวและเสียงตอบรับ - Create Hub Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0B0F1A] text-white min-h-screen">

    <!-- HEADER BAR -->
    <nav class="bg-[#0F1525] border-b border-white/5 p-5">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="{{ route('provider.dashboard') }}"
                class="text-yellow-400 hover:underline text-sm">
                ← Dashboard
            </a>
            <h1 class="text-xl font-semibold">
                รีวิวจากลูกค้า
            </h1>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-8">

        <!-- SUMMARY CARD -->
        <div class="bg-[#131A2E] rounded-2xl p-8 border border-white/5 mb-10 flex items-center justify-between">

            <div>
                <h2 class="text-4xl font-bold text-yellow-400">
                    4.8 <span class="text-xl">★</span>
                </h2>

                <p class="text-gray-400 text-xs uppercase tracking-wider mt-2">
                    คะแนนรีวิวเฉลี่ยของคุณ
                </p>
            </div>

            <div class="text-right text-gray-400 text-sm">
                จากทั้งหมด <strong>{{ count($reviews ?? []) }}</strong> ความคิดเห็น
            </div>

        </div>


        <!-- REVIEWS LIST -->
        <div class="space-y-6">

            @forelse($reviews ?? [] as $review)

            <div class="bg-[#131A2E] p-6 rounded-2xl border border-white/5">

                <!-- TOP -->
                <div class="flex justify-between items-start mb-5">

                    <div class="flex gap-3 items-center">

                        <div class="w-10 h-10 bg-[#0F1525] rounded-full flex items-center justify-center font-semibold border border-white/10">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>

                        <div>
                            <h4 class="font-semibold">
                                {{ $review->user->name }}
                            </h4>

                            <p class="text-xs text-gray-500">
                                {{ $review->created_at->format('d/m/Y') }}
                                • จองสตูดิโอ: {{ $review->studio->name }}
                            </p>
                        </div>

                    </div>

                    <div class="text-yellow-400 font-semibold">
                        {{ str_repeat('★', $review->rating) }}
                        {{ str_repeat('☆', 5 - $review->rating) }}
                    </div>

                </div>

                <!-- COMMENT -->
                <p class="text-gray-400 text-sm leading-relaxed bg-[#0F1525] p-4 rounded-xl italic border border-white/5">
                    "{{ $review->comment }}"
                </p>


                @if($review->reply)

                <!-- REPLY -->
                <div class="mt-6 ml-6 p-4 bg-yellow-500/10 rounded-xl border-l-4 border-yellow-400">
                    <p class="text-xs font-semibold text-yellow-400 uppercase mb-1">
                        การตอบกลับจากคุณ:
                    </p>
                    <p class="text-sm text-gray-300">
                        {{ $review->reply }}
                    </p>
                </div>

                @else

                <!-- REPLY FORM -->
                <form action="{{ route('provider.reviews.reply', $review->id) }}"
                    method="POST"
                    class="mt-6 flex gap-3">
                    @csrf
                    @method('PATCH')

                    <input type="text"
                        name="reply"
                        placeholder="เขียนข้อความตอบกลับ..."
                        class="flex-1 px-4 py-3 rounded-xl bg-[#0F1525] border border-white/10 text-sm focus:border-yellow-400 outline-none">

                    <button type="submit"
                        class="px-5 py-3 bg-yellow-500 text-black rounded-xl text-sm font-semibold hover:bg-yellow-400 transition">
                        ตอบกลับ
                    </button>
                </form>

                @endif

            </div>

            @empty

            <div class="text-center py-24 bg-[#131A2E] rounded-2xl border border-dashed border-white/10 text-gray-500">
                <p class="text-lg">ยังไม่มีรีวิวจากลูกค้าในขณะนี้</p>
            </div>

            @endforelse

        </div>

    </main>

</body>

</html>