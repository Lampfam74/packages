<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("audit_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->string("event")->index();
            $table->string("table_name")->nullable();
            $table->unsignedBigInteger("record_id")->nullable();

            $table->string("method")->nullable();
            $table->string("url")->nullable();

            $table->json("old_data")->nullable();
            $table->json("new_data")->nullable();

            $table->ipAddress("ip_address")->nullable();
            $table->text("user_agent")->nullable();

            $table->boolean("is_suspicious")->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("audit_logs");
    }
};
