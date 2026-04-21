<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user yang login punya role yang ada di dalam daftar $roles
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar ke halaman utama
        return redirect('/');
    }
} // Pastikan ada kurung tutup ini untuk menutup class!
