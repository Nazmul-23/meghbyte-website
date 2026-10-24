<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /** Only active admin/editor users may use the admin area. Pass "admin" to require the admin role. */
    public function handle(Request $request, Closure $next, ?string $level = null): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canUseAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        }

        if ($level === 'admin' && ! $user->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
