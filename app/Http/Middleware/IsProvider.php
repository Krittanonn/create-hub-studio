<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // เรียกใช้ตัวนี้

class IsProvider
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. ดึง User มาแล้วบอก Intelephense ว่านี่คือ Model User นะ
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. เช็คเงื่อนไข (ใส่เงื่อนไขให้แน่นหนาขึ้น)
        if ($user && $user->role === 'provider') {
            return $next($request);
        }

        // 3. ถ้าไม่ใช่ ดีดกลับหน้าแรกพร้อมแจ้งเตือน
        return redirect('/')->with('error', 'สิทธิ์เฉพาะเจ้าของสตูดิโอเท่านั้น');
    }
}