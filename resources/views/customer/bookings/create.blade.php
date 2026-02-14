<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จอง {{ $studio->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-6">
        จอง {{ $studio->name }}
    </h1>

    <form method="POST"
          action="{{ route('customer.bookings.store', $studio->id) }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf

        <div>
            <label class="block mb-1">วันที่</label>
            <input type="date"
                   name="date"
                   required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">เวลาเริ่ม</label>
            <input type="time"
                   name="start_time"
                   required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">เวลาสิ้นสุด</label>
            <input type="time"
                   name="end_time"
                   required
                   class="w-full border rounded px-3 py-2">
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded">
            ยืนยันการจอง
        </button>

    </form>

</div>

</body>
</html>
