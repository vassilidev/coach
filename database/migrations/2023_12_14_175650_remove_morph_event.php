<?php

use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('events', static function (Blueprint $table) {
            $table->foreignIdFor(Teacher::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });

        Event::each(static function (Event $event) {
            $event->update([
                'teacher_id' => DB::table('eventables')->select('eventable_id')->where('event_id', '=', $event->id)->first()->eventable_id,
            ]);
        });

        Schema::table('events', static function (Blueprint $table) {
            $table->dropForeignIdFor(Teacher::class);

            $table->string('teacher_id')->nullable(false)->change();
        });

        Schema::table('events', static function (Blueprint $table) {
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });


        Schema::drop('eventables');

        Schema::enableForeignKeyConstraints();
    }
};
