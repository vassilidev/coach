<?php

use App\Enums\Reservation\Status;
use App\Models\Checkout;
use App\Models\User;
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
            $table->foreignIdFor(\App\Models\Event::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status')->default(Status::NEW);
            // TODO: Check "  Referencing column 'checkout_id' and referenced column 'id' in foreign key constraint 'reservations_checkout_id_foreign' are incompatible. "
//            $table->foreignIdFor(Checkout::class)->constrained((new Checkout)->getTable())->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
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
