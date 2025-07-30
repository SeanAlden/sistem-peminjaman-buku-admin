<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!$request->expectsJson()) {
    //         if ($request->is('admin') || $request->is('admin/*')) {
    //             return redirect()->route('admin.login'); // arahkan ke admin.login jika path diawali /admin
    //         }

    //         return redirect()->route('login'); // default (jika Anda punya user biasa)
    //     }
    // }

    public function handle(Request $request, Closure $next): Response
    {
        // Jika user tidak login atau bukan admin
        if (!Auth::check() || Auth::user()->usertype !== 'admin') {
            // Jika request bukan request JSON (bukan API)
            if (!$request->expectsJson()) {
                return redirect()->route('admin.login');
            }

            // Jika request API
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // Jika user terautentikasi dan usertype = admin
        return $next($request);
    }
}
