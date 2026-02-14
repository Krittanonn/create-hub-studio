@extends('admin.layouts.app')

@section('title', 'รายละเอียดการจอง #' . $booking->id)

@section('content')

<div class="mb-10">
    <a href="{{ route('admin.bookings.index') }}"
       class="text-blue-400 hover:text-blue-300 mb-6 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>
        กลับไปหน้ารายการจอง
    </a>

    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-white">
                รายละเอียดการจอง #{{ $booking->id }}
            </h1>

            <p class="text-blue-300/60">
                จองเมื่อวันที่
                {{ optional($booking->created_at)->format('d/m/Y H:i') }}
            </p>
        </div>

        <span class="px-4 py-2 rounded-xl font-semibold
                     bg-blue-500/20 text-blue-400 border border-blue-500/40">
            สถานะ: {{ strtoupper($booking->status) }}
        </span>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- LEFT COLUMN --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Studio & Time --}}
        <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">
            <h3 class="text-lg font-bold mb-6 border-b border-blue-900/30 pb-3 text-white">
                ข้อมูลสตูดิโอและเวลา
            </h3>

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-blue-300/60">สตูดิโอ</p>
                    <p class="font-semibold text-lg text-white">
                        {{ $booking->studio->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-blue-300/60">วันใช้บริการ</p>
                    <p class="font-semibold text-lg text-white">
                        {{ optional($booking->start_time)->format('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-blue-300/60">เวลาเริ่ม</p>
                    <p class="font-semibold text-blue-400">
                        {{ optional($booking->start_time)->format('H:i') }} น.
                    </p>
                </div>

                <div>
                    <p class="text-sm text-blue-300/60">เวลาสิ้นสุด</p>
                    <p class="font-semibold text-blue-400">
                        {{ optional($booking->end_time)->format('H:i') }} น.
                    </p>
                </div>

            </div>
        </div>


        {{-- Items --}}
        <div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">

            <div class="p-6 bg-[#0F1A2F] border-b border-blue-900/30">
                <h3 class="font-bold text-white text-lg">
                    รายการบริการและอุปกรณ์เพิ่มเติม
                </h3>
            </div>

            <table class="w-full text-left">
                <thead class="bg-[#0F1A2F] text-xs text-blue-300/60 uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">รายการ</th>
                        <th class="px-6 py-4 text-center">จำนวน</th>
                        <th class="px-6 py-4 text-right">ราคา/หน่วย</th>
                        <th class="px-6 py-4 text-right">รวม</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-900/30">

                    @foreach($booking->items as $item)
                    <tr class="hover:bg-blue-900/20 transition text-sm">
                        <td class="px-6 py-4 font-medium text-white">
                            {{ $item->itemable->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center text-blue-300/70">
                            {{ $item->quantity }}
                        </td>

                        <td class="px-6 py-4 text-right text-blue-400">
                            ฿{{ number_format($item->price_at_time, 2) }}
                        </td>

                        <td class="px-6 py-4 text-right text-blue-400 font-semibold">
                            ฿{{ number_format($item->price_at_time * $item->quantity, 2) }}
                        </td>
                    </tr>
                    @endforeach

                </tbody>

                <tfoot class="bg-[#0F1A2F]">
                    <tr>
                        <td colspan="3"
                            class="px-6 py-5 text-right font-bold uppercase text-blue-300">
                            ยอดรวมสุทธิ
                        </td>

                        <td class="px-6 py-5 text-right font-bold text-2xl text-blue-400">
                            ฿{{ number_format($booking->total_price, 2) }}
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>

    </div>


    {{-- RIGHT COLUMN --}}
    <div class="space-y-6">

        {{-- Customer --}}
        <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">
            <h3 class="text-lg font-bold mb-6 text-white border-b border-blue-900/30 pb-3">
                ข้อมูลลูกค้า
            </h3>

            <div class="space-y-2 text-blue-300/70 text-sm">
                <p><strong class="text-white">ชื่อ:</strong> {{ $booking->user->name }}</p>
                <p><strong class="text-white">Email:</strong> {{ $booking->user->email }}</p>
                <p><strong class="text-white">เบอร์:</strong> {{ $booking->user->phone ?? '-' }}</p>
            </div>
        </div>


        {{-- Payment --}}
        <div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20">

            <h3 class="text-lg font-bold mb-6 text-white border-b border-blue-900/30 pb-3">
                สถานะการชำระเงิน
            </h3>

            <p class="mb-4 text-blue-400 font-semibold uppercase">
                {{ strtoupper($booking->payment_status) }}
            </p>

            @if($booking->payment)
                <div class="text-sm text-blue-300/70 space-y-2">
                    <p>
                        วิธีชำระ:
                        <span class="text-white font-medium">
                            {{ strtoupper($booking->payment->payment_method) }}
                        </span>
                    </p>

                    <p>
                        วันที่จ่าย:
                        <span class="text-white font-medium">
                            {{ optional($booking->payment->paid_at)->format('d/m/Y H:i') }}
                        </span>
                    </p>
                </div>
            @endif

        </div>

    </div>

</div>

@endsection
