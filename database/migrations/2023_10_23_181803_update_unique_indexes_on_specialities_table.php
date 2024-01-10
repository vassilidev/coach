<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('specialities', static function (Blueprint $table) {
            $table->dropUnique(['slug']);

            $table->unique(['category_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specialities', static function (Blueprint $table) {
            $table->dropUnique(['category_id', 'slug']);

            $table->unique('slug');
        });
    }
};
