<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->string('login_provider')->nullable()->after('email');
            $table->string('socialite_id')->nullable()->after('login_provider');
            $table->string('socialite_token')->nullable()->after('socialite_id');
            $table->string('socialite_refresh_token')->nullable()->after('socialite_token');

            $table->unique(['login_provider', 'socialite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn(['login_provider', 'socialite_id', 'socialite_token', 'socialite_refresh_token']);
        });
    }
};
