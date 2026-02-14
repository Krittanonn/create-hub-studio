<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการช่วงเวลาสตูดิโอ - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white p-6 shadow-xl">
            <h2 class="text-2xl font-bold mb-8 text-center text-blue-400">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition hover:bg-slate-800">📊 Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-slate-800">📅 การจอง</a>
                <a href="{{ route('admin.availability.index') }}" class="block py-2.5 px-4 rounded bg-blue-600 shadow-lg font-bold">🛠️ ปิดช่วงเวลา/ซ่อมบำรุง</a>
                <a href="{{ route('admin.studios.index') }}" class="block py-2.5 px-4 rounded transition hover:bg-slate-800">🏢 สตูดิโอ</a>
                <hr class="border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition hover:bg-red-600">🚪 ออกจากระบบ</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">จัดการความพร้อมใช้งาน (Availability)</h1>
                    <p class="text-gray-500">กำหนดวันและเวลาที่ต้องการปิดสตูดิโอ หรือช่วงที่งดรับการจอง</p>
                </div>
                <button onclick="toggleModal('modal-add-availability')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg shadow-lg font-bold transition flex items-center">
                    <i class="fas fa-calendar-plus mr-2"></i> ปิดช่วงเวลาการจอง
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold border-b">
                        <tr>
                            <th class="px-6 py-4">สตูดิโอ</th>
                            <th class="px-6 py-4">วันที่</th>
                            <th class="px-6 py-4">ช่วงเวลา</th>
                            <th class="px-6 py-4">เหตุผล / หมายเหตุ</th>
                            <th class="px-6 py-4 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($availabilities as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->studio->name }}</td>
                            <td class="px-6 py-4 text-gray-600 italic">
                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-bold border border-blue-100">
                                    {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $item->reason ?? 'ไม่มีระบุ' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 uppercase">
                                    Blocked
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-calendar-check text-4xl mb-3 block"></i>
                                สตูดิโอว่างทุกวัน ยังไม่มีการบล็อกช่วงเวลา
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="modal-add-availability" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="p-6 border-b bg-gray-50">
                <h3 class="text-xl font-bold text-gray-800">ปิดช่วงเวลาการจอง (Block Schedule)</h3>
            </div>
            <form action="{{ route('admin.availability.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">เลือกสตูดิโอ</label>
                    <select name="studio_id" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @isset($studios)
                            @foreach($studios as $studio)
                                <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                            @endforeach
                        @else
                            <option value="">(ไม่มีข้อมูลสตูดิโอ)</option>
                        @endisset
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">วันที่</label>
                        <input type="date" name="date" required class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">เวลาเริ่ม</label>
                            <input type="time" name="start_time" required class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">เวลาสิ้นสุด</label>
                            <input type="time" name="end_time" required class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">เหตุผลในการปิด (Optional)</label>
                    <input type="text" name="reason" placeholder="เช่น ปิดซ่อมบำรุง, ติดธุระส่วนตัว" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" onclick="toggleModal('modal-add-availability')" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">ยกเลิก</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">บันทึกรายการ</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>
</body>
</html>