<?php

namespace Lampdevs\AuditLog\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        "user_id",
        "event",
        "table_name",
        "record_id",
        "method",
        "url",
        "old_data",
        "new_data",
        "ip_address",
        "user_agent",
        "is_suspicious"
    ];

    protected $casts = [
        "old_data" => "array",
        "new_data" => "array",
        "is_suspicious" => "boolean"
    ];
}
