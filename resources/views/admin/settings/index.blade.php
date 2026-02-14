<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex min-h-screen">

    <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl flex-shrink-0">
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-bold text-blue-400">Create Hub</h2>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Admin Management</p>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-chart-pie w-5"></i>
                <span>แดชบอร์ด</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-calendar-check w-5"></i>
                <span>รายการจอง</span>
            </a>
            <a href="{{ route('admin.studios.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <i class="fas fa-camera-retro w-5"></i>
                <span>สตูดิโอ</span>
            </a>
            <div class="pt-4 pb-2">
                <p class="text-[10px] font-bold text-slate-500 uppercase px-4 italic">System</p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl bg-blue-600 shadow-lg font-bold transition">
                <i class="fas fa-cog w-5"></i>
                <span>ตั้งค่าระบบ</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="pt-10">
                @csrf
                <button type="submit" class="flex items-center space-x-3 py-3 px-4 w-full rounded-xl text-red-400 hover:bg-red-600 hover:text-white transition font-bold">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>ออกจากระบบ</span>
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-black text-gray-800">System Settings</h1>
            <p class="text-gray-500 italic">ปรับแต่งการทำงานหลักของแพลตฟอร์ม (Static Mockup Mode)</p>
        </header>

        <div class="max-w-4xl space-y-8">
            
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b bg-gray-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-university mr-2 text-blue-500"></i>ข้อมูลบัญชีรับเงิน (Payment Gateway)</h3>
                    <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-1 rounded font-black uppercase">Official</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">ชื่อบัญชี / ธนาคาร</label>
                        <input type="text" value="บจก. ครีเอท ฮับ สตูดิโอ (ไทยแลนด์)" readonly class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-gray-600 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">เลขที่บัญชี / PromptPay</label>
                        <input type="text" value="098-765-4321" readonly class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-gray-600 font-mono font-bold">
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b bg-gray-50/50">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-percentage mr-2 text-emerald-500"></i>นโยบายการจองและค่ามัดจำ</h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex items-center justify-between max-w-md">
                        <div>
                            <p class="font-bold text-gray-700">ค่ามัดจำเริ่มต้น (Default Deposit)</p>
                            <p class="text-xs text-gray-400 italic">เปอร์เซ็นต์ที่ลูกค้าต้องจ่ายทันทีเพื่อยืนยันการจอง</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="number" value="50" readonly class="w-20 bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-center font-black text-emerald-600">
                            <span class="font-bold text-gray-400">%</span>
                        </div>
                    </div>
                    <hr class="border-gray-50">
                    <div class="flex items-center justify-between max-w-md">
                        <div>
                            <p class="font-bold text-gray-700">เวลาการยกเลิก (Cancellation Grace Period)</p>
                            <p class="text-xs text-gray-400 italic">ระยะเวลาที่อนุญาตให้ยกเลิกก่อนเริ่มงาน (ชั่วโมง)</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="number" value="24" readonly class="w-20 bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-center font-black text-blue-600">
                            <span class="font-bold text-gray-400">ชม.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b bg-gray-50/50">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-bell mr-2 text-orange-500"></i>การแจ้งเตือนและสถานะระบบ</h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700 uppercase text-xs">Email Notifications</p>
                                <p class="text-sm text-gray-500">ส่งอีเมลยืนยันการจองไปยังลูกค้าอัตโนมัติ</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase">Enabled</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700 uppercase text-xs">Maintenance Mode</p>
                                <p class="text-sm text-gray-500">ปิดระบบชั่วคราวเพื่อปรับปรุง (เฉพาะ Admin เข้าได้)</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-full text-[10px] font-black uppercase">Disabled</span>
                    </div>
                </div>
            </section>

            <div class="pt-4 flex justify-end">
                <button type="button" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest text-sm opacity-50 cursor-not-allowed">
                    Update Settings (ReadOnly)
                </button>
            </div>
        </div>
    </main>

</body>
</html>