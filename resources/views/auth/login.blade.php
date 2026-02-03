<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Create Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">เข้าสู่ระบบ</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-2 mb-4 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">อีเมล</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-6">
                <label class="block mb-1">รหัสผ่าน</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">
                เข้าสู่ระบบ
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            ยังไม่มีบัญชี? <a href="{{ route('register') }}" class="text-blue-500">สมัครสมาชิก</a>
        </p>
    </div>

</body>
</html>