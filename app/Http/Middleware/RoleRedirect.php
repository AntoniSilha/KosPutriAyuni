<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Redirect authenticated users based on their role
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->isAdmin()) {
                return redirect('/admin');
            }

            if ($user->isPenghuni()) {
                return redirect('/dashboard');
            }

            // Regular user stays on landing page
        }

        return $next($request);
    }
}
