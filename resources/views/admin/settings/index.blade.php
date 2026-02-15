@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-black text-white">
        System Settings
    </h1>
    <p class="text-blue-300/60 italic">
        ปรับแต่งการทำงานหลักของแพลตฟอร์ม
    </p>
</header>

<div class="max-w-4xl space-y-8">

    {{-- Payment Gateway --}}
    <section class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">
        <div class="p-6 border-b border-blue-900/30 bg-[#0F1A2F] flex items-center justify-between">
            <h3 class="font-bold text-white">
                <i class="fas fa-university mr-2 text-blue-400"></i>
                ข้อมูลบัญชีรับเงิน (Payment Gateway)
            </h3>
            <span class="text-[10px] bg-blue-500/20 text-blue-400 px-2 py-1 rounded font-bold uppercase">
                Official
            </span>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-blue-300/60 uppercase mb-2 tracking-widest">
                    ชื่อบัญชี / ธนาคาร
                </label>
                <input type="text"
                       value="บจก. ครีเอท ฮับ สตูดิโอ (ไทยแลนด์)"
                       readonly
                       class="w-full bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-blue-300 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-blue-300/60 uppercase mb-2 tracking-widest">
                    เลขที่บัญชี / PromptPay
                </label>
                <input type="text"
                       value="098-765-4321"
                       readonly
                       class="w-full bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-blue-300 font-mono font-bold">
            </div>
        </div>
    </section>


    {{-- Booking Policy --}}
    <section class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">
        <div class="p-6 border-b border-blue-900/30 bg-[#0F1A2F]">
            <h3 class="font-bold text-white">
                <i class="fas fa-percentage mr-2 text-emerald-400"></i>
                นโยบายการจองและค่ามัดจำ
            </h3>
        </div>

        <div class="p-8 space-y-6">

            <div class="flex items-center justify-between max-w-md">
                <div>
                    <p class="font-bold text-white">
                        ค่ามัดจำเริ่มต้น (Default Deposit)
                    </p>
                    <p class="text-xs text-blue-300/60 italic">
                        เปอร์เซ็นต์ที่ลูกค้าต้องจ่ายทันทีเพื่อยืนยันการจอง
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <input type="number"
                           value="50"
                           readonly
                           class="w-20 bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-center font-black text-emerald-400">
                    <span class="font-bold text-blue-300/60">%</span>
                </div>
            </div>

            <hr class="border-blue-900/30">

            <div class="flex items-center justify-between max-w-md">
                <div>
                    <p class="font-bold text-white">
                        เวลาการยกเลิก (Cancellation Grace Period)
                    </p>
                    <p class="text-xs text-blue-300/60 italic">
                        ระยะเวลาที่อนุญาตให้ยกเลิกก่อนเริ่มงาน (ชั่วโมง)
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <input type="number"
                           value="24"
                           readonly
                           class="w-20 bg-[#0F1A2F] border border-blue-900/40 rounded-xl px-4 py-3 text-center font-black text-blue-400">
                    <span class="font-bold text-blue-300/60">ชม.</span>
                </div>
            </div>

        </div>
    </section>


    {{-- Notifications --}}
    <section class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">
        <div class="p-6 border-b border-blue-900/30 bg-[#0F1A2F]">
            <h3 class="font-bold text-white">
                <i class="fas fa-bell mr-2 text-orange-400"></i>
                การแจ้งเตือนและสถานะระบบ
            </h3>
        </div>

        <div class="p-8 space-y-6">

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <p class="font-bold text-white uppercase text-xs">
                            Email Notifications
                        </p>
                        <p class="text-sm text-blue-300/60">
                            ส่งอีเมลยืนยันการจองไปยังลูกค้าอัตโนมัติ
                        </p>
                    </div>
                </div>

                <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-[10px] font-bold uppercase">
                    Enabled
                </span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center text-red-400">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div>
                        <p class="font-bold text-white uppercase text-xs">
                            Maintenance Mode
                        </p>
                        <p class="text-sm text-blue-300/60">
                            ปิดระบบชั่วคราวเพื่อปรับปรุง
                        </p>
                    </div>
                </div>

                <span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-[10px] font-bold uppercase">
                    Disabled
                </span>
            </div>

        </div>
    </section>


    <div class="pt-6 flex justify-end">
        <button type="button"
                class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold shadow-md shadow-blue-900/30 opacity-50 cursor-not-allowed uppercase tracking-widest text-sm">
            Update Settings (ReadOnly)
        </button>
    </div>

</div>

@endsection
