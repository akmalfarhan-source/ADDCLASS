<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UmkmOwnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admins can also access UMKM owner areas
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->isUmkmOwner()) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
