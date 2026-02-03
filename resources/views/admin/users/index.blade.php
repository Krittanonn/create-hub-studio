<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600">← กลับหน้าหลัก</a>
            <h1 class="text-2xl font-bold">จัดการผู้ใช้งานในระบบ</h1>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4">ชื่อ</th>
                        <th class="p-4">อีเมล</th>
                        <th class="p-4">บทบาท</th>
                        <th class="p-4">วันที่สมัคร</th>
                        <th class="p-4">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- โครงสร้างรอรับ $users จาก Controller --}}
                    @forelse($users ?? [] as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $user->name }}</td>
                            <td class="p-4">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role == 'provider' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-4">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="p-4">
                                <button class="text-red-600 text-sm">ระงับสิทธิ์</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">ไม่พบรายชื่อผู้ใช้งาน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>