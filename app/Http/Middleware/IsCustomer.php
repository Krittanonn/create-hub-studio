<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // เรียกใช้ Facade เพื่อความแม่นยำ

class IsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ตรวจสอบว่า Login หรือยัง และเป็น Customer หรือไม่
        if ($user && $user->role === 'customer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'สิทธิ์เฉพาะลูกค้าเท่านั้น');
    }
}