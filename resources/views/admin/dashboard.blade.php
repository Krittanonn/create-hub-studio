@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-bold text-white">
            แดชบอร์ดสรุปผล
        </h1>
        <p class="text-blue-300/60 italic">
            ยินดีต้อนรับกลับมา, ข้อมูลอัปเดตล่าสุด ณ วันนี้
        </p>
    </div>

    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium text-blue-300 bg-[#111C33] px-4 py-2 rounded-xl border border-blue-900/40">
            <i class="far fa-calendar-alt mr-2 text-blue-400"></i>
            {{ date('d F Y') }}
        </span>
    </div>
</header>


{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    {{-- Revenue --}}
    <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 hover:border-blue-500/40 transition">
        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 mb-4">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div class="text-xs text-blue-300/60 font-bold uppercase tracking-widest">
            รายได้สุทธิ (ยืนยันแล้ว)
        </div>
        <div class="text-2xl font-black text-blue-400 mt-2">
            ฿{{ number_format($totalRevenue, 2) }}
        </div>
    </div>

    {{-- Users --}}
    <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 hover:border-blue-500/40 transition">
        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 mb-4">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div class="text-xs text-blue-300/60 font-bold uppercase tracking-widest">
            สมาชิกทั้งหมด
        </div>
        <div class="text-2xl font-black text-white mt-2">
            {{ number_format($totalUsers) }}
        </div>
    </div>

    {{-- Studios --}}
    <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 hover:border-blue-500/40 transition">
        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 mb-4">
            <i class="fas fa-building text-xl"></i>
        </div>
        <div class="text-xs text-blue-300/60 font-bold uppercase tracking-widest">
            สตูดิโอในระบบ
        </div>
        <div class="text-2xl font-black text-white mt-2">
            {{ number_format($totalStudios) }}
        </div>
    </div>

    {{-- Pending --}}
    <div class="bg-[#111C33] p-6 rounded-2xl border border-red-500/30 shadow-lg shadow-black/20 hover:border-red-500/60 transition">
        <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 mb-4">
            <i class="fas fa-hourglass-half text-xl"></i>
        </div>
        <div class="text-xs text-red-400/70 font-bold uppercase tracking-widest">
            รอตรวจสอบชำระเงิน
        </div>
        <div class="text-2xl font-black text-red-400 mt-2">
            {{ $pendingPayments }}
        </div>
    </div>

</div>


{{-- ตาราง + Sidebar Content --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- รายการจองล่าสุด --}}
    <div class="lg:col-span-2 bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">

        <div class="p-6 border-b border-blue-900/30 flex justify-between items-center bg-[#0F1A2F]">
            <h3 class="font-bold text-white">
                <i class="fas fa-history mr-2 text-blue-400"></i>
                รายการจองล่าสุด
            </h3>

            <a href="{{ route('admin.bookings.index') }}"
               class="text-xs text-blue-400 font-bold hover:text-blue-300 uppercase">
                ดูรายการทั้งหมด
            </a>
        </div>

        <table class="w-full text-left">
            <thead class="bg-[#0F1A2F] text-[10px] font-bold text-blue-300/60 uppercase tracking-widest">
                <tr>
                    <th class="px-6 py-4">สตูดิโอ</th>
                    <th class="px-6 py-4">ผู้จอง</th>
                    <th class="px-6 py-4">ยอดเงิน</th>
                    <th class="px-6 py-4 text-center">สถานะ</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-blue-900/30">
                @forelse($recentBookings as $booking)
                <tr class="text-sm hover:bg-blue-900/20 transition">
                    <td class="px-6 py-4 font-semibold text-white">
                        {{ $booking->studio->name }}
                    </td>

                    <td class="px-6 py-4 text-blue-300/70 italic">
                        {{ $booking->user->name }}
                    </td>

                    <td class="px-6 py-4 font-bold text-blue-400">
                        ฿{{ number_format($booking->total_price, 2) }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                            {{ $booking->status == 'confirmed'
                                ? 'bg-green-500/20 text-green-400'
                                : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4"
                        class="px-6 py-10 text-center text-blue-300/50 italic text-sm">
                        ยังไม่มีรายการจองในระบบ
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>


    {{-- เมนูด่วน --}}
    <div class="space-y-6">

        <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">
            <h3 class="font-bold text-white mb-5 border-b border-blue-900/30 pb-2">
                เมนูจัดการด่วน
            </h3>

            <div class="space-y-3">

                <a href="{{ route('admin.payments.verify') }}"
                   class="flex items-center justify-between p-4 rounded-xl
                          bg-orange-500/10 text-orange-400
                          hover:bg-orange-600 hover:text-white transition">
                    <div class="flex items-center font-bold text-sm">
                        <i class="fas fa-check-double mr-3"></i>
                        ตรวจสอบสลิปเงินโอน
                    </div>
                    <span class="bg-orange-500/20 text-orange-400 text-[10px] px-2 py-1 rounded-md font-bold">
                        {{ $pendingPayments }}
                    </span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center p-4 rounded-xl
                          bg-blue-500/10 text-blue-400
                          hover:bg-blue-600 hover:text-white transition">
                    <div class="flex items-center font-bold text-sm">
                        <i class="fas fa-user-lock mr-3"></i>
                        จัดการสิทธิ์ผู้ใช้งาน
                    </div>
                </a>

                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center p-4 rounded-xl
                          bg-indigo-500/10 text-indigo-400
                          hover:bg-indigo-600 hover:text-white transition">
                    <div class="flex items-center font-bold text-sm">
                        <i class="fas fa-chart-line mr-3"></i>
                        สรุปรายงานรายได้
                    </div>
                </a>

            </div>
        </div>

    </div>

</div>

@endsection
