<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventable', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->morphs('ownable');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventable');
    }
};
