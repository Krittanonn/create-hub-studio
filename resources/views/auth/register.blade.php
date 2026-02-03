<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">สมัครสมาชิก</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-1">ชื่อ-นามสกุล</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">อีเมล</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">รหัสผ่าน</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-6">
                <label class="block mb-1 font-bold text-blue-600">สมัครสมาชิกในฐานะ:</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="role" value="customer" checked> ลูกค้า</label>
                    <label><input type="radio" name="role" value="provider"> เจ้าของสตูดิโอ</label>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                สมัครสมาชิก
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}" class="text-blue-500">เข้าสู่ระบบ</a>
        </p>
    </div>

</body>
</html>