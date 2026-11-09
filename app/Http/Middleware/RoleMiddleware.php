<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    
public function handle(
    Request $request,
    Closure $next,
    string ...$roles
): Response {
    if (!$request->user()) {
        return redirect()->route('login');
    }

    // Periksa status akun pada setiap akses route yang memakai middleware role
    if ($request->user()->status !== 'aktif') {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Admin.',
            ]);
    }

    if (!in_array($request->user()->role, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    $response = $next($request);

$response->headers->set(
    'Cache-Control',
    'no-store, no-cache, must-revalidate, max-age=0'
);

$response->headers->set('Pragma', 'no-cache');

$response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

return $response;
}

}