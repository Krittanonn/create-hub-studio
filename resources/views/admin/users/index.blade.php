<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้งาน - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl">
            <h2 class="text-2xl font-bold mb-8 text-center text-blue-400">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">📊 Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">📅 การจอง</a>
                <a href="{{ route('admin.reviews.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800">⭐ จัดการรีวิว</a>
                <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded bg-blue-600 shadow-lg font-semibold">👥 ผู้ใช้งาน</a>
                <hr class="border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-red-600">🚪 ออกจากระบบ</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold">จัดการผู้ใช้งาน</h1>
                    <p class="text-gray-500">บริหารจัดการสิทธิ์และสถานะการเข้าใช้งานของสมาชิก</p>
                </div>
                
                <form action="{{ route('admin.users.index') }}" method="GET" class="w-full md:w-96 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="ค้นหาชื่อ หรือ อีเมล..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">ข้อมูลผู้ใช้งาน</th>
                            <th class="px-6 py-4">เบอร์โทรศัพท์</th>
                            <th class="px-6 py-4 text-center">บทบาท (Role)</th>
                            <th class="px-6 py-4 text-center">สถานะ</th>
                            <th class="px-6 py-4">วันที่สมัคร</th>
                            <th class="px-6 py-4 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-100 text-purple-700',
                                        'provider' => 'bg-blue-100 text-blue-700',
                                        'customer' => 'bg-green-100 text-green-700',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase {{ $roleColors[$user->role] ?? 'bg-gray-100' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center text-green-600">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span> ใช้งานปกติ
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-red-600">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></span> ระงับการใช้
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="p-2 {{ $user->is_active ? 'text-orange-500 hover:bg-orange-50' : 'text-green-500 hover:bg-green-50' }} rounded-lg transition" 
                                                title="{{ $user->is_active ? 'ระงับการใช้งาน' : 'เปิดการใช้งาน' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        </button>
                                    </form>

                                    @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบผู้ใช้รายนี้? ข้อมูลทั้งหมดจะหายไป')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users-slash text-4xl mb-3 block"></i>
                                ไม่พบข้อมูลผู้ใช้งานที่ค้นหา
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </main>
    </div>

</body>
</html>