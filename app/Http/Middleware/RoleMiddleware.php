<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  
     * @param  string|null  $guard  
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, $guard = 'admin')
    {
        // Cek apakah pengguna sudah login dengan guard yang sesuai
        if (!Auth::guard($guard)->check()) {
            return redirect()->route($guard . '.login')
                ->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Ambil role yang diizinkan (bisa pakai | untuk multiple role)
        $roles = is_array($role) ? $role : explode('|', $role);

        // Cek apakah user punya role yang diizinkan
        $user = Auth::guard($guard)->user();
        if (!$user->hasRole($roles)) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin yang diperlukan.');
        }

        return $next($request);
    }
}
