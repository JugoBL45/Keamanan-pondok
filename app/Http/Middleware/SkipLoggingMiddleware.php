<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkipLoggingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika path request adalah 'users/activity-logs'
        if ($request->is('users/activity-logs')) {
            return response()->json(['message' => 'Route ignored for logging'], 200);
        }

        return $next($request);
    }
}
