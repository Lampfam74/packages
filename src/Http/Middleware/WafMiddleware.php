<?php

namespace Lampedev\SecuritySuite\Http\Middleware;

use Closure;
use Lampedev\SecuritySuite\Services\WafService;

class WafMiddleware
{
    public function handle($request, Closure $next)
    {
        $waf = new WafService();

        if ($waf->isBlockedIp($request->ip())) {
            abort(403, "🚫 Access denied by WAF");
        }

        if ($waf->detectAttackPatterns($request)) {
            $waf->blockIp($request->ip());

            abort(403, "🚨 Malicious request detected");
        }

        return $next($request);
    }
}