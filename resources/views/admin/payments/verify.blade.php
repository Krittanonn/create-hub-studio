@extends('admin.layouts.app')

@section('title', 'ตรวจสอบยอดเงิน')

@section('content')

<h1 class="text-3xl font-bold mb-10 text-white">
    รายการรอตรวจสอบการโอนเงิน
</h1>

@if(session('success'))
<div class="mb-6 p-4 bg-green-500/20 border border-green-500/40 text-green-400 rounded-xl">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 gap-6">

@forelse($payments as $payment)

<div class="bg-[#111C33] p-6 rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 flex justify-between items-center hover:border-blue-500/40 transition">

    <div>
        <p class="font-bold text-xl text-blue-400">
            ฿{{ number_format($payment->amount, 2) }}
        </p>

        <p class="text-sm text-blue-300/70">
            ลูกค้า: {{ $payment->booking->user->name }}
        </p>

        <p class="text-sm text-blue-400 font-semibold">
            สตูดิโอ: {{ $payment->booking->studio->name }}
        </p>
    </div>

    <div class="flex gap-3">

        <form action="{{ route('admin.payments.approve', $payment->id) }}"
              method="POST">
            @csrf
            @method('PATCH')
            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-bold shadow-md shadow-green-900/30 transition">
                อนุมัติ
            </button>
        </form>

        <form action="{{ route('admin.payments.reject', $payment->id) }}"
              method="POST">
            @csrf
            @method('PATCH')
            <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl font-bold shadow-md shadow-red-900/30 transition">
                ปฏิเสธ
            </button>
        </form>

    </div>

</div>

@empty

<div class="text-center text-blue-300/50 py-24 italic">
    ไม่มีรายการรอตรวจสอบ
</div>

@endforelse

</div>

@endsection
