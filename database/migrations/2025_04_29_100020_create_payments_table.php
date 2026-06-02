<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('gateway', 30);
            $table->string('gateway_order_id', 120)->nullable();
            $table->string('gateway_payment_id', 120)->nullable();
            $table->string('gateway_signature', 255)->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 5)->default('INR');
            $table->enum('status', ['initiated', 'success', 'failed', 'refunded'])->default('initiated');
            $table->string('method', 30)->nullable();
            $table->json('response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('gateway_order_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
