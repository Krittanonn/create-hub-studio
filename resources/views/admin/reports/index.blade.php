@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

<h1 class="text-3xl font-bold mb-8">รายงานสรุปผลระบบ</h1>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow border">
        <p class="text-sm text-gray-400 uppercase font-bold">รายได้รวม</p>
        <p class="text-3xl font-black text-emerald-600 mt-2">
            ฿{{ number_format($totalRevenue, 2) }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow border">
        <p class="text-sm text-gray-400 uppercase font-bold">Pending</p>
        <p class="text-3xl font-black text-yellow-500 mt-2">
            {{ $statusCounts['pending'] ?? 0 }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow border">
        <p class="text-sm text-gray-400 uppercase font-bold">Confirmed</p>
        <p class="text-3xl font-black text-green-600 mt-2">
            {{ $statusCounts['confirmed'] ?? 0 }}
        </p>
    </div>

</div>

{{-- Monthly Revenue --}}
<div class="bg-white p-6 rounded-2xl shadow border mb-10">
    <h2 class="font-bold mb-4">รายได้รายเดือน (ปี {{ now()->year }})</h2>

    <table class="w-full text-left">
        <thead class="text-xs uppercase text-gray-400">
            <tr>
                <th class="py-3">เดือน</th>
                <th class="py-3 text-right">รายได้</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @for($m = 1; $m <= 12; $m++)
                <tr>
                    <td class="py-2">
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </td>
                    <td class="py-2 text-right font-bold">
                        ฿{{ number_format($monthlyRevenue[$m] ?? 0, 2) }}
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

{{-- Top Studios --}}
<div class="bg-white p-6 rounded-2xl shadow border mb-10">
    <h2 class="font-bold mb-4">Top 5 Studios (รายได้สูงสุด)</h2>

    <table class="w-full text-left">
        <thead class="text-xs uppercase text-gray-400">
            <tr>
                <th class="py-3">ชื่อสตูดิโอ</th>
                <th class="py-3 text-right">รายได้รวม</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($topStudios as $studio)
                <tr>
                    <td class="py-3 font-semibold">
                        {{ $studio->name }}
                    </td>
                    <td class="py-3 text-right font-bold text-blue-600">
                        ฿{{ number_format($studio->bookings_sum_total_price ?? 0, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Recent Bookings --}}
<div class="bg-white p-6 rounded-2xl shadow border">
    <h2 class="font-bold mb-4">รายการจองล่าสุด</h2>

    <table class="w-full text-left">
        <thead class="text-xs uppercase text-gray-400">
            <tr>
                <th class="py-3">ลูกค้า</th>
                <th class="py-3">สตูดิโอ</th>
                <th class="py-3 text-right">ยอดเงิน</th>
                <th class="py-3 text-center">สถานะ</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($recentBookings as $booking)
                <tr>
                    <td class="py-3">{{ $booking->user->name }}</td>
                    <td class="py-3">{{ $booking->studio->name }}</td>
                    <td class="py-3 text-right font-bold">
                        ฿{{ number_format($booking->total_price, 2) }}
                    </td>
                    <td class="py-3 text-center">
                        <span class="px-3 py-1 text-xs rounded-full
                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
