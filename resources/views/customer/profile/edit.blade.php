<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตั้งค่าโปรไฟล์ | Create Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#07101F] text-white min-h-screen">

<div class="max-w-4xl mx-auto py-14 px-4">
    
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black italic uppercase tracking-tighter">Profile Settings</h1>
            <p class="text-blue-300/50 font-medium">จัดการข้อมูลส่วนตัวและรหัสผ่านของคุณ</p>
        </div>
        <a href="{{ route('customer.explore.index') }}" class="text-blue-400 hover:text-white transition-all flex items-center font-bold">
            <i class="fa-solid fa-house mr-2"></i> กลับหน้าหลัก
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl flex items-center">
            <i class="fa-solid fa-circle-check mr-3"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PATCH')

        <div class="lg:col-span-1">
            <div class="bg-[#111C33]/50 p-8 rounded-[3rem] border border-blue-900/30 text-center">
                <div class="relative inline-block mb-6">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D8ABC&color=fff&size=128' }}" 
                         alt="Avatar" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-blue-600/20 shadow-2xl">
                    <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all">
                        <i class="fa-solid fa-camera text-sm"></i>
                        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                    </label>
                </div>
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <p class="text-blue-300/40 text-sm mb-4">{{ $user->email }}</p>
                <p class="text-[10px] text-blue-500 uppercase font-black tracking-widest">Customer Member</p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#111C33]/50 p-8 rounded-[3rem] border border-blue-900/30 space-y-6">
                <h3 class="text-lg font-bold text-blue-300 mb-2 italic underline decoration-blue-500/30 underline-offset-8">ข้อมูลทั่วไป</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2 tracking-widest">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-3.5 text-white focus:outline-none focus:border-blue-500 transition-all @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2 tracking-widest">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-3.5 text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>
            </div>

            <div class="bg-[#111C33]/50 p-8 rounded-[3rem] border border-blue-900/30 space-y-6">
                <h3 class="text-lg font-bold text-blue-300 mb-2 italic underline decoration-blue-500/30 underline-offset-8">ความปลอดภัย</h3>
                
                <p class="text-xs text-blue-300/40 font-medium">* เว้นว่างไว้หากไม่ต้องการเปลี่ยนรหัสผ่าน</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2 tracking-widest">รหัสผ่านใหม่</label>
                        <input type="password" name="password" 
                               class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-3.5 text-white focus:outline-none focus:border-blue-500 transition-all @error('password') border-red-500 @enderror">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-blue-300/50 uppercase mb-2 tracking-widest">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full bg-[#07101F] border border-blue-900/40 rounded-2xl px-5 py-3.5 text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-[2rem] shadow-xl shadow-blue-600/20 transition-all transform active:scale-95 text-lg">
                <i class="fa-solid fa-floppy-disk mr-2"></i> บันทึกการเปลี่ยนแปลง
            </button>
        </div>
    </form>

</div>

</body>
</html>