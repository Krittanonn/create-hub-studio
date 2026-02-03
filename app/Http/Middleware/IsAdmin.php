<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // ใช้ \Illuminate\Support\Facades\Auth แทน auth()
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'สิทธิ์เฉพาะผู้ดูแลระบบเท่านั้น');
    }
}
