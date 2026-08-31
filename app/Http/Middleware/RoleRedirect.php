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
            $user = auth()->user(); //mengecek apakah pengguna sudah login dan mendapatkan data pengguna yang sedang login

            if ($user->isAdmin()) {
                return redirect('/admin'); // jika role admin maka akan diarahkan ke halaman admin
            } 

            if ($user->isPenghuni()) {
                return redirect('/dashboard'); // jika role penghuni maka akan diarahkan ke halaman dashboard
            }

            // Regular user stays on landing page
        }

        return $next($request);
    }
}
