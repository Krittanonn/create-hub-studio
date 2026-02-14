@php
    $isDashboard = request()->routeIs('admin.dashboard');
    $isBookings = request()->routeIs('admin.bookings.*');
    $isStudios = request()->routeIs('admin.studios.*');
    $isUsers = request()->routeIs('admin.users.*');
    $isPayments = request()->routeIs('admin.payments.*');
    $isSettings = request()->routeIs('admin.settings.*');
@endphp

<aside class="w-64 bg-slate-900 text-white p-6 shadow-xl flex-shrink-0">

    <div class="mb-10 text-center">
        <h2 class="text-2xl font-bold text-blue-400">Create Hub</h2>
        <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">
            Admin Management
        </p>
    </div>

    <nav class="space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isDashboard ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-chart-pie w-5"></i>
            <span>แดชบอร์ด</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4">
                ระบบจัดการ
            </p>
        </div>

        {{-- Bookings --}}
        <a href="{{ route('admin.bookings.index') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isBookings ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-calendar-check w-5"></i>
            <span>รายการจอง</span>
        </a>

        {{-- Studios --}}
        <a href="{{ route('admin.studios.index') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isStudios ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-camera-retro w-5"></i>
            <span>สตูดิโอ</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isUsers ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-user-shield w-5"></i>
            <span>ผู้ใช้งาน</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4">
                การเงิน
            </p>
        </div>

        {{-- Payments --}}
        <a href="{{ route('admin.payments.verify') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isPayments ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-receipt w-5"></i>
            <span>ตรวจสอบยอดโอน</span>
        </a>

        {{-- Settings --}}
        <a href="{{ route('admin.settings.index') }}"
           class="flex items-center space-x-3 py-3 px-4 rounded-xl transition
           {{ $isSettings ? 'bg-blue-600 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-300' }}">
            <i class="fas fa-cog w-5"></i>
            <span>ตั้งค่าระบบ</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="pt-10">
            @csrf
            <button type="submit"
                class="flex items-center space-x-3 py-3 px-4 w-full rounded-xl text-red-400 hover:bg-red-600 hover:text-white transition font-bold">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>ออกจากระบบ</span>
            </button>
        </form>

    </nav>
</aside>