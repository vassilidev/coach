<?php

use App\Enums\Stripe\Checkout\PaymentStatus;
use App\Enums\Stripe\Checkout\Status;
use App\Models\User;
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
        Schema::create('stripe_checkouts', static function (Blueprint $table) {
            $table->ulid('id')->index();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('checkout_id');
            /** @see PaymentStatus */
            $table->string('payment_status')->default(PaymentStatus::UNPAID);
            /** @see Status */
            $table->string('status')->default(Status::OPEN);
            $table->unsignedBigInteger('amount');
            $table->json('checkout_data');
            $table->string('redirect_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_checkouts');
    }
};
