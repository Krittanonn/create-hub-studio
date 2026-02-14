@extends('admin.layouts.app')

@section('title', 'จัดการรายการจอง')

@section('content')

<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-bold text-white">
            รายการการจองทั้งหมด
        </h1>
        <p class="text-blue-300/60">
            ติดตามสถานะการจอง การชำระเงิน และข้อมูลการใช้บริการสตูดิโอ
        </p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/40 text-green-400 rounded-xl">
        {{ session('success') }}
    </div>
@endif

<div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">

    <table class="w-full text-left border-collapse">
        <thead class="bg-[#0F1A2F] text-blue-300/60 uppercase text-xs font-bold tracking-widest">
            <tr>
                <th class="px-6 py-4">ลูกค้า / สตูดิโอ</th>
                <th class="px-6 py-4">วัน-เวลา</th>
                <th class="px-6 py-4 text-center">ยอดรวม</th>
                <th class="px-6 py-4 text-center">สถานะจอง</th>
                <th class="px-6 py-4 text-center">การชำระเงิน</th>
                <th class="px-6 py-4 text-right">จัดการ</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-900/30">
            @forelse($bookings as $booking)

            <tr class="hover:bg-blue-900/20 transition text-sm">

                <td class="px-6 py-4">
                    <div class="font-semibold text-white">
                        {{ $booking->user->name }}
                    </div>
                    <div class="text-xs text-blue-400 font-semibold">
                        {{ $booking->studio->name }}
                    </div>
                </td>

                <td class="px-6 py-4 text-sm text-blue-300/70">
                    <div>
                        {{ $booking->start_time->format('d/m/Y') }}
                    </div>
                    <div class="text-xs text-blue-300/50">
                        {{ $booking->start_time->format('H:i') }}
                        -
                        {{ $booking->end_time->format('H:i') }}
                    </div>
                </td>

                <td class="px-6 py-4 text-center font-bold text-blue-400">
                    ฿{{ number_format($booking->total_price, 2) }}
                </td>

                <td class="px-6 py-4 text-center">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-500/20 text-yellow-400',
                            'confirmed' => 'bg-green-500/20 text-green-400',
                            'cancelled' => 'bg-red-500/20 text-red-400',
                            'completed' => 'bg-blue-500/20 text-blue-400',
                        ];
                        $statusClass = $statusClasses[$booking->status] ?? 'bg-gray-500/20 text-gray-400';
                    @endphp

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest {{ $statusClass }}">
                        {{ strtoupper($booking->status) }}
                    </span>
                </td>

                <td class="px-6 py-4 text-center">
                    @if($booking->payment_status === 'paid')
                        <span class="text-green-400 text-xs font-bold uppercase border border-green-400 px-2 py-0.5 rounded">
                            PAID
                        </span>
                    @else
                        <span class="text-gray-400 text-xs font-bold uppercase border border-gray-500 px-2 py-0.5 rounded">
                            UNPAID
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.bookings.show', $booking->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-blue-900/30">
                        <i class="fas fa-eye mr-2"></i>
                        รายละเอียด
                    </a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-blue-300/50 italic">
                    ไม่พบรายการจองในระบบ
                </td>
            </tr>

            @endforelse
        </tbody>
    </table>

</div>

<div class="mt-8 text-blue-300/70">
    {{ $bookings->links() }}
</div>

@endsection
