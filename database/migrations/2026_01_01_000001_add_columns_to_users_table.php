<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The users table (created by the default Laravel migration) is missing
     * columns needed by this platform. We add them here rather than altering
     * the default migration to keep the default install cleanly separable.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url', 500)->nullable()->after('email');
            $table->string('timezone', 50)->default('UTC')->after('avatar_url');
            $table->boolean('is_active')->default(true)->after('timezone');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_url', 'timezone', 'is_active', 'last_login_at']);
        });
    }
};
