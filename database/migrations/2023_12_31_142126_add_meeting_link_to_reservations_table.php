<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', static function (Blueprint $table) {
            $table->longText('meeting_link')->nullable()->after('stripe_checkout_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', static function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
};
