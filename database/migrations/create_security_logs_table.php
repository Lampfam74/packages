<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('event_type'); // login, update, delete, attack, waf_block

            $table->string('ip_address')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();

            $table->text('user_agent')->nullable();

            $table->json('payload')->nullable();
            $table->string('severity')->default('info'); // low, medium, high, critical

            $table->timestamps();

            $table->index(['ip_address', 'event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};