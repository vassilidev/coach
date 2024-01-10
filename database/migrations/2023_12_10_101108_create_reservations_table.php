<?php

use App\Enums\Reservation\Status;
use App\Models\{Checkout, Event, Speciality, User};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Speciality::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('comment')->nullable();
            $table->string('status')->default(Status::NEW->value);
            $table->foreignIdFor(Event::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Checkout::class, 'stripe_checkout_id')->constrained((new Checkout)->getTable())->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
