<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moneybag_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('checkout_id')->nullable();
            $table->string('transaction_id')->nullable()->index();
            $table->string('status');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BDT');
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moneybag_transactions');
    }
};