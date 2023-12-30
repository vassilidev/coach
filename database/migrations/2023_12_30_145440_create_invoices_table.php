<?php

use App\Models\Checkout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', static function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->index();
            $table->longText('preview_url');
            $table->longText('file_url');
            $table->unsignedBigInteger('amount');
            $table->foreignIdFor(Checkout::class, 'stripe_checkout_id')->constrained((new Checkout)->getTable())->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('invoice_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
