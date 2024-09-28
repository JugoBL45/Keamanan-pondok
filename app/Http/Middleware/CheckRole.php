<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }
        
        return redirect('/'); // Redirect to home or error page if not authorized
    }
}


