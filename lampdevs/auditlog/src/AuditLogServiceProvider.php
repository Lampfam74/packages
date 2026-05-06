<?php

namespace Lampdevs\AuditLog;

use Illuminate\Support\ServiceProvider;

class AuditLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        app('router')->pushMiddlewareToGroup(
            'web',
            \Lampdevs\AuditLog\Middleware\AuditMiddleware::class
        );
    }

    public function register() {}
}
