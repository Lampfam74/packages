<?php

namespace Lampedev\SecuritySuite\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lampedev\SecuritySuite\Models\BlockedIp;

class WafService
{
    /**
     * Advanced attack patterns (SQLi, XSS, RCE, etc.)
     */
    protected array $patterns = [
        // SQL Injection
        '/\b(select|union|insert|delete|update|drop|alter)\b.*\b(from|into|table)\b/i',

        // XSS
        '/<\s*script\b/i',
        '/javascript\s*:/i',

        // RCE / Code Injection
        '/eval\s*\(/i',
        '/base64_decode\s*\(/i',
        '/system\s*\(/i',
        '/exec\s*\(/i',

        // Path Traversal
        '/\.\.\//i',
        '/\.\.\\\\/i',
    ];

    /**
     * Detect malicious patterns in request
     */
    public function detectAttackPatterns(Request $request): bool
    {
        $payload = $this->normalizeRequestData($request);

        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $payload)) {

                Log::warning('WAF Attack Detected', [
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'pattern' => $pattern,
                    'payload' => $payload,
                ]);

                return true;
            }
        }

        return false;
    }

    /**
     * Normalize all request input into a single string
     */
    protected function normalizeRequestData(Request $request): string
    {
        return json_encode([
            'query' => $request->query(),
            'body' => $request->post(),
            'headers' => $request->headers->all(),
            'url' => $request->fullUrl(),
        ]);
    }

    /**
     * Check if IP is already blocked
     */
    public function isBlockedIp(string $ip): bool
    {
        return BlockedIp::where('ip', $ip)->exists();
    }

    /**
     * Block IP with metadata
     */
    public function blockIp(string $ip, string $reason = 'malicious activity'): void
    {
        BlockedIp::firstOrCreate([
            'ip' => $ip
        ], [
            'reason' => $reason,
            'blocked_at' => now(),
        ]);

        Log::alert('IP Blocked by WAF', [
            'ip' => $ip,
            'reason' => $reason,
        ]);
    }

    /**
     * Unblock IP (admin feature)
     */
    public function unblockIp(string $ip): bool
    {
        return BlockedIp::where('ip', $ip)->delete() > 0;
    }
}