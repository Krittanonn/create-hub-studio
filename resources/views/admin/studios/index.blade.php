@extends('admin.layouts.app')

@section('title', 'จัดการสตูดิโอ')

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-bold text-white">
        จัดการสตูดิโอ
    </h1>
    <p class="text-blue-300/60 italic">
        ตรวจสอบและแก้ไขสถานะสตูดิโอทั้งหมดในระบบ
    </p>
</header>

<div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">

    <table class="w-full text-left">
        <thead class="bg-[#0F1A2F] text-[10px] font-bold text-blue-300/60 uppercase tracking-widest border-b border-blue-900/30">
            <tr>
                <th class="px-6 py-4">ชื่อสตูดิโอ</th>
                <th class="px-6 py-4">เจ้าของ</th>
                <th class="px-6 py-4 text-center">สถานะ</th>
                <th class="px-6 py-4 text-right">การจัดการ</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-900/30">
            @foreach($studios as $studio)
            <tr class="hover:bg-blue-900/20 transition text-sm">

                <td class="px-6 py-4">
                    <div class="font-bold text-white">
                        {{ $studio->name }}
                    </div>
                </td>

                <td class="px-6 py-4">
                    <div class="text-sm text-blue-300/70">
                        {{ $studio->user->name ?? 'N/A' }}
                    </div>
                </td>

                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                        {{ $studio->status == 'active'
                            ? 'bg-green-500/20 text-green-400'
                            : ($studio->status == 'maintenance'
                                ? 'bg-yellow-500/20 text-yellow-400'
                                : 'bg-red-500/20 text-red-400') }}">
                        {{ $studio->status }}
                    </span>
                </td>

                <td class="px-6 py-4 text-right">
                    <button
                        data-id="{{ $studio->id }}"
                        data-status="{{ $studio->status }}"
                        class="open-status-modal p-2 bg-blue-500/20 text-blue-400 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-md shadow-blue-900/30">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>


{{-- Modal --}}
<div id="statusModal"
    class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">

    <div class="bg-[#111C33] border border-blue-900/40 rounded-2xl shadow-2xl w-full max-w-sm p-6">

        <h3 class="font-black text-white uppercase mb-6 border-b border-blue-900/30 pb-3">
            อัปเดตสถานะ
        </h3>

        <form id="statusForm" action="" method="POST">
            @csrf
            @method('PATCH')

            <select name="status"
                id="statusSelect"
                class="w-full bg-[#0F1A2F] border border-blue-900/40 text-blue-300 rounded-xl px-3 py-2 mb-6 focus:outline-none focus:border-blue-500">
                <option value="active">เปิดใช้งาน (Active)</option>
                <option value="maintenance">ปิดซ่อมบำรุง (Maintenance)</option>
                <option value="closed">ปิดการใช้งาน (Closed)</option>
            </select>

            <div class="flex gap-3">
                <button type="button"
                    onclick="document.getElementById('statusModal').classList.add('hidden')"
                    class="flex-1 py-2 text-blue-300/60 font-bold hover:text-white transition">
                    ยกเลิก
                </button>

                <button type="submit"
                    class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-900/30 transition">
                    บันทึก
                </button>
            </div>
        </form>

    </div>
</div>


{{-- Script --}}
<script>
    function openStatusModal(id, currentStatus) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = document.getElementById('statusSelect');

        form.action = `/admin/studios/${id}`;
        select.value = currentStatus;

        modal.classList.remove('hidden');
    }
</script>

@endsection
