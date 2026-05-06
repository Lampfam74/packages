<?php

namespace Lampedev\SecuritySuite\Services;

use Lampedev\SecuritySuite\Models\SecurityLog;

class ThreatDetector
{
    public function analyze(string $ip): array
    {
        $logs = SecurityLog::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->get();

        $score = 0;

        if ($logs->count() > 30) {
            $score += 50;
        }

        if ($logs->where('event_type', 'attack')->count() > 0) {
            $score += 40;
        }

        return [
            'risk_score' => $score,
            'status' => $score > 70 ? 'HIGH_RISK' : 'SAFE'
        ];
    }
}