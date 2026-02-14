<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรีวิว - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0B0F1A] text-white flex min-h-screen">

    <aside class="w-64 bg-[#0F1525] border-r border-white/5 min-h-screen p-6 flex flex-col fixed">
        <div class="mb-10">
            <h2 class="text-2xl font-semibold italic text-white">CREATE<span class="text-blue-500">HUB</span></h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Provider Mode</p>
        </div>
        <nav class="space-y-2 flex-1 text-sm overflow-y-auto pr-2 custom-scrollbar">
    <div class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-2 ml-4">Main Menu</div>
    
    <a href="{{ route('provider.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-chart-pie w-5"></i> แผงควบคุม
    </a>

    <a href="{{ route('provider.studios.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.studios.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-house-laptop w-5"></i> สตูดิโอของฉัน
    </a>

    <a href="{{ route('provider.bookings.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.bookings.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-check w-5"></i> รายการจอง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Resources</div>

    <a href="{{ route('provider.equipments.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.equipments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-camera w-5"></i> อุปกรณ์เสริม
    </a>

    <a href="{{ route('provider.staffs.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.staffs.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-user-tie w-5"></i> ทีมงานพนักงาน
    </a>

    <a href="{{ route('provider.availability.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.availability.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-calendar-xmark w-5"></i> จัดการช่วงเวลาว่าง
    </a>

    <div class="pt-4 pb-2 text-[10px] text-gray-500 uppercase tracking-widest font-bold ml-4">Finance & Community</div>

    <a href="{{ route('provider.payouts.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.payouts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-wallet w-5"></i> การเงิน/ถอนเงิน
    </a>


    <a href="{{ route('provider.reviews.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('provider.reviews.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-gray-400 hover:bg-white/5' }}">
        <i class="fa-solid fa-star w-5"></i> รีวิวจากลูกค้า
    </a>
</nav>
<div class="mt-auto pt-6 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition group">
                    <i class="fa-solid fa-right-from-bracket group-hover:rotate-180 transition-transform duration-300"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-10">
        
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-white">รีวิวจากลูกค้า</h1>
            <p class="text-gray-400 mt-1">ติดตามความคิดเห็นและตอบกลับความพึงพอใจของลูกค้า</p>
        </header>

        <div class="space-y-6">
            @forelse($reviews as $review)
            <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-8 transition hover:border-blue-500/30">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 font-bold border border-blue-500/20">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">{{ $review->user->name }}</h4>
                            <p class="text-xs text-gray-500">รีวิวสตูดิโอ: <span class="text-gray-300">{{ $review->studio->name }}</span></p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end">
                        <div class="flex text-yellow-400 gap-1 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-sm"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="bg-white/[0.02] rounded-xl p-4 mb-6 border border-white/5">
                    <p class="text-gray-300 leading-relaxed italic">" {{ $review->comment }} "</p>
                </div>

                @if($review->provider_reply)
                    <div class="ml-10 border-l-2 border-blue-500/30 pl-6 space-y-2">
                        <div class="flex items-center gap-2 text-blue-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-reply"></i> การตอบกลับของคุณ
                        </div>
                        <p class="text-gray-400 text-sm italic">{{ $review->provider_reply }}</p>
                        <p class="text-[10px] text-gray-600">ตอบกลับเมื่อ: {{ $review->replied_at->format('d M Y H:i') }}</p>
                    </div>
                @else
                    <form action="{{ route('provider.reviews.reply', $review->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <div class="relative">
                            <textarea 
                                name="provider_reply" 
                                rows="2" 
                                class="w-full bg-[#0B0F1A] border border-white/5 rounded-xl p-4 text-sm text-gray-300 focus:outline-none focus:border-blue-500 transition placeholder:text-gray-700"
                                placeholder="เขียนข้อความตอบกลับลูกค้าที่นี่..."
                                required
                            ></textarea>
                            <button type="submit" class="absolute bottom-3 right-3 bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> ส่งคำตอบ
                            </button>
                        </div>
                    </form>
                @endif
            </div>
            @empty
            <div class="bg-[#131A2E] rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-comment-slash text-3xl text-gray-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-400">ยังไม่มีรีวิวในขณะนี้</h3>
                <p class="text-gray-500 text-sm mt-2">เมื่อลูกค้าใช้บริการเสร็จและให้คะแนน ข้อมูลจะมาแสดงที่นี่</p>
            </div>
            @endforelse

            <div class="mt-10">
                {{ $reviews->links() }}
            </div>
        </div>
    </main>

</body>
</html>