<?php

namespace Lampdevs\AuditLog\Services;

use Lampdevs\AuditLog\Models\AuditLog;

class AuditService
{
    public static function log(array $data)
    {
        $data["is_suspicious"] = self::detect($data);

        return AuditLog::create($data);
    }

    public static function detect($data): bool
    {
        $patterns = ["select *","drop table","union select","../","<script"];

        foreach ($patterns as $p) {
            if (stripos(json_encode($data), $p) !== false) {
                return true;
            }
        }

        return false;
    }
}
