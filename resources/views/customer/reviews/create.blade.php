<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เขียนรีวิว - {{ $booking->studio->name }} | Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen">

<div class="max-w-2xl mx-auto py-14 px-4">
    
    <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center text-blue-400 hover:text-white mb-10 transition-all font-bold group">
        <i class="fa-solid fa-chevron-left mr-2 group-hover:-translate-x-1"></i> กลับไปรายการจอง
    </a>

    <div class="bg-[#111C33]/80 backdrop-blur-xl rounded-[3rem] border border-blue-900/40 shadow-2xl overflow-hidden">
        
        <div class="p-10 text-center border-b border-blue-900/20 bg-blue-900/10">
            <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-star text-3xl text-yellow-500"></i>
            </div>
            <h1 class="text-3xl font-black italic uppercase tracking-tighter">Share Your Experience</h1>
            <p class="text-blue-300/50 font-medium">แบ่งปันความประทับใจที่คุณมีต่อ {{ $booking->studio->name }}</p>
        </div>

        <form action="{{ route('customer.reviews.store', $booking->id) }}" method="POST" class="p-10 space-y-8">
            @csrf

            <div class="text-center">
                <label class="block text-xs font-bold text-blue-300/50 uppercase mb-4 tracking-widest">ให้คะแนนความพึงพอใจ</label>
                <div class="flex justify-center gap-4 text-3xl" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="text-blue-900 hover:text-yellow-500 transition-colors duration-200 rating-star" data-value="{{ $i }}">
                        <i class="fa-solid fa-star"></i>
                    </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="" required>
                @error('rating') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-blue-300/50 uppercase mb-3 tracking-widest">ความคิดเห็นของคุณ</label>
                <textarea name="comment" rows="5" placeholder="คุณชอบอะไรในสตูดิโอนี้? บริการเป็นอย่างไรบ้าง?"
                          class="w-full bg-[#07101F] border border-blue-900/40 rounded-[2rem] px-6 py-5 text-white focus:outline-none focus:border-blue-500 transition-all placeholder:text-blue-900/50 @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-black py-5 rounded-[2rem] shadow-xl shadow-yellow-900/10 transition-all transform active:scale-95 text-lg">
                <i class="fa-solid fa-paper-plane mr-2"></i> ส่งรีวิว
            </button>
        </form>
    </div>

</div>

<script>
    function setRating(val) {
        document.getElementById('rating-input').value = val;
        const stars = document.querySelectorAll('.rating-star');
        
        stars.forEach((star, index) => {
            if (index < val) {
                star.classList.remove('text-blue-900');
                star.classList.add('text-yellow-500');
            } else {
                star.classList.remove('text-yellow-500');
                star.classList.add('text-blue-900');
            }
        });
    }
</script>

</body>
</html>