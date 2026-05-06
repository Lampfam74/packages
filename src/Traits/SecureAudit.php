<?php

namespace Lampedev\SecuritySuite\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Lampedev\SecuritySuite\Models\SecurityLog;

trait SecureAudit
{
    public static function bootSecureAudit(): void
    {
        static::created(fn(Model $m) => self::log('created', $m));
        static::updated(fn(Model $m) => self::log('updated', $m, $m->getOriginal(), $m->getChanges()));
        static::deleted(fn(Model $m) => self::log('deleted', $m, $m->toArray()));
    }

    protected static function log($event, $model, $old = null, $new = null)
    {
        SecurityLog::create([
            'user_id' => Auth::id(),
            'event_type' => $event,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'user_agent' => request()->userAgent(),
            'payload' => [
                'old' => $old,
                'new' => $new
            ],
            'severity' => 'info'
        ]);
    }
}