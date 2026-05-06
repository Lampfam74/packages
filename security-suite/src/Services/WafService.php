<?php

namespace Lampedev\SecuritySuite\Services;

use Illuminate\Http\Request;
use Lampedev\SecuritySuite\Models\BlockedIp;

class WafService
{
    protected array $patterns = [
        '/select .* from/i',
        '/union.*select/i',
        '/<script>/i',
        '/base64_decode/i',
        '/eval\(/i',
    ];

    public function detectAttackPatterns(Request $request): bool
    {
        $input = json_encode($request->all());

        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    public function isBlockedIp(string $ip): bool
    {
        return BlockedIp::where('ip', $ip)->exists();
    }

    public function blockIp(string $ip): void
    {
        BlockedIp::firstOrCreate([
            'ip' => $ip
        ]);
    }
}