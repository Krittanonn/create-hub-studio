<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>{{ $studio->name }} | Create Hub Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-[#0B1220] via-[#0E1627] to-[#07101F] text-white min-h-screen">

<div class="max-w-6xl mx-auto py-14 px-4">

    <a href="{{ route('customer.explore.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-bold mb-10 transition-all group">
        <i class="fa-solid fa-chevron-left mr-2 group-hover:-translate-x-1 transition-transform"></i> กลับหน้า Explore
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="h-[400px] bg-[#111C33] rounded-[3rem] border border-blue-900/40 flex items-center justify-center relative overflow-hidden group shadow-2xl">
                <i class="fa-solid fa-image text-8xl text-blue-900/20 group-hover:scale-110 transition-transform duration-700"></i>
                <div class="absolute bottom-6 left-6 bg-black/40 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10">
                    <span class="text-xs font-bold uppercase tracking-widest">{{ $studio->type }} Studio</span>
                </div>
            </div>

            <div class="bg-[#111C33]/50 p-10 rounded-[3rem] border border-blue-900/30">
                <h1 class="text-4xl font-black mb-4 text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-400">{{ $studio->name }}</h1>
                <p class="flex items-center text-blue-300/60 mb-8 font-medium">
                    <i class="fa-solid fa-location-dot mr-3 text-blue-500"></i> {{ $studio->location }}
                </p>
                <div class="prose prose-invert max-w-none text-blue-100/70 leading-relaxed text-lg">
                    {{ $studio->description }}
                </div>
            </div>

            <div class="bg-[#111C33]/50 p-10 rounded-[3rem] border border-blue-900/30">
                <h2 class="text-2xl font-bold mb-8 flex items-center">
                    <i class="fa-solid fa-lightbulb mr-4 text-yellow-500"></i> อุปกรณ์เสริมที่มีให้บริการ
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($studio->equipments as $item)
                        <div class="bg-[#0F1A2F] p-5 rounded-2xl border border-blue-900/20 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-blue-100">{{ $item->name }}</p>
                                <p class="text-xs text-blue-400">฿{{ number_format($item->price_per_unit) }} / ชิ้น</p>
                            </div>
                            <i class="fa-solid fa-plus-circle text-blue-900"></i>
                        </div>
                    @empty
                        <p class="text-blue-300/40 italic">ไม่มีอุปกรณ์เสริมเพิ่มเติม</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-10 space-y-6">
                <div class="bg-gradient-to-b from-[#1E2E4D] to-[#111C33] p-10 rounded-[3rem] border border-blue-400/30 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
                    
                    <p class="text-blue-300/60 uppercase tracking-tighter font-black text-xs mb-2">อัตราค่าบริการสตูดิโอ</p>
                    <div class="flex items-baseline gap-2 mb-8">
                        <span class="text-5xl font-black text-white">฿{{ number_format($studio->price_per_hour) }}</span>
                        <span class="text-blue-300/60">/ ชั่วโมง</span>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center text-sm text-blue-100/80 bg-blue-900/20 p-3 rounded-xl border border-blue-800/20">
                            <i class="fa-solid fa-check-circle text-green-500 mr-3"></i> ระบบเสียง Hi-End
                        </div>
                        <div class="flex items-center text-sm text-blue-100/80 bg-blue-900/20 p-3 rounded-xl border border-blue-800/20">
                            <i class="fa-solid fa-check-circle text-green-500 mr-3"></i> เครื่องปรับอากาศ
                        </div>
                        <div class="flex items-center text-sm text-blue-100/80 bg-blue-900/20 p-3 rounded-xl border border-blue-800/20">
                            <i class="fa-solid fa-check-circle text-green-500 mr-3"></i> ความเป็นส่วนตัวสูง
                        </div>
                    </div>

                    <a href="{{ route('customer.bookings.create', $studio->id) }}" 
                       class="block w-full text-center bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-600/30 transition-all hover:scale-[1.02] active:scale-95 text-lg">
                        จองพื้นที่นี้เลย
                    </a>
                </div>

                <div class="bg-[#111C33]/50 p-8 rounded-[3rem] border border-blue-900/30">
                    <h3 class="font-bold text-blue-300 mb-4 flex items-center">
                        <i class="fa-solid fa-user-tie mr-3"></i> พนักงานที่มีให้บริการ
                    </h3>
                    @foreach($studio->staffs as $staff)
                        <div class="text-sm mb-2 text-blue-100/60 flex justify-between">
                            <span>{{ $staff->position }}</span>
                            <span class="text-blue-400 font-bold">฿{{ number_format($staff->price_per_day) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>