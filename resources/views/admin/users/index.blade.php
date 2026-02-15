@extends('admin.layouts.app')

@section('title', 'จัดการผู้ใช้งาน')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div>
        <h1 class="text-3xl font-bold text-white">
            จัดการผู้ใช้งาน
        </h1>
        <p class="text-blue-300/60">
            บริหารจัดการสิทธิ์และสถานะการเข้าใช้งานของสมาชิก
        </p>
    </div>
    
    <form action="{{ route('admin.users.index') }}"
          method="GET"
          class="w-full md:w-96 flex gap-2">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="ค้นหาชื่อ หรือ อีเมล..."
               class="flex-1 px-4 py-2 bg-[#0F1A2F] border border-blue-900/40 text-blue-300 rounded-xl focus:outline-none focus:border-blue-500">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-900/30">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/40 text-green-400 rounded-xl">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif

<div class="bg-[#111C33] rounded-2xl border border-blue-900/40 shadow-lg shadow-black/20 overflow-hidden">

    <table class="w-full text-left border-collapse">
        <thead class="bg-[#0F1A2F] text-blue-300/60 uppercase text-xs font-bold tracking-widest border-b border-blue-900/30">
            <tr>
                <th class="px-6 py-4">ข้อมูลผู้ใช้งาน</th>
                <th class="px-6 py-4">เบอร์โทรศัพท์</th>
                <th class="px-6 py-4 text-center">บทบาท</th>
                <th class="px-6 py-4 text-center">สถานะ</th>
                <th class="px-6 py-4">วันที่สมัคร</th>
                <th class="px-6 py-4 text-right">จัดการ</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-900/30 text-sm">
            @forelse($users as $user)
            <tr class="hover:bg-blue-900/20 transition">

                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 font-bold uppercase">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-white">
                                {{ $user->name }}
                            </div>
                            <div class="text-xs text-blue-300/60">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 text-blue-300/70">
                    {{ $user->phone ?? '-' }}
                </td>

                <td class="px-6 py-4 text-center">
                    @php
                        $roleColors = [
                            'admin' => 'bg-purple-500/20 text-purple-400',
                            'provider' => 'bg-blue-500/20 text-blue-400',
                            'customer' => 'bg-green-500/20 text-green-400',
                        ];
                    @endphp

                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest {{ $roleColors[$user->role] ?? 'bg-gray-500/20 text-gray-400' }}">
                        {{ $user->role }}
                    </span>
                </td>

                <td class="px-6 py-4 text-center">
                    @if($user->is_active)
                        <span class="inline-flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            ใช้งานปกติ
                        </span>
                    @else
                        <span class="inline-flex items-center text-red-400">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                            ระงับการใช้
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-blue-300/60">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>

                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">

                        {{-- Toggle Status --}}
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="p-2 {{ $user->is_active ? 'text-orange-400 hover:bg-orange-500/20' : 'text-green-400 hover:bg-green-500/20' }} rounded-xl transition"
                                    title="{{ $user->is_active ? 'ระงับการใช้งาน' : 'เปิดการใช้งาน' }}">
                                <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                            </button>
                        </form>

                        {{-- Delete --}}
                        @if(Auth::id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                              method="POST"
                              onsubmit="return confirm('ยืนยันการลบผู้ใช้รายนี้?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="p-2 text-red-400 hover:bg-red-500/20 rounded-xl transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @endif

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-blue-300/50 italic">
                    ไม่พบข้อมูลผู้ใช้งาน
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<div class="mt-8 text-blue-300/70">
    {{ $users->appends(request()->query())->links() }}
</div>

@endsection
