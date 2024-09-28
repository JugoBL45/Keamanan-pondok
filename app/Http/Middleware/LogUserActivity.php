<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\ActivityLog;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $activity = sprintf('%s %s', $request->method(), $request->path());
            ActivityLog::log($activity);
        }

        return $response;
    }
}
