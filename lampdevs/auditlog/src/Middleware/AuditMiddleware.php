<?php

namespace Lampdevs\AuditLog\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lampdevs\AuditLog\Services\AuditService;

class AuditMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        AuditService::log([
            "user_id" => Auth::id(),
            "event" => "request",
            "method" => $request->method(),
            "url" => $request->fullUrl(),
            "ip_address" => $request->ip(),
            "user_agent" => $request->userAgent(),
            "new_data" => $request->all()
        ]);

        return $response;
    }
}
