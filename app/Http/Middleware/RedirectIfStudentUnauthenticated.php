<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfStudentUnauthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
