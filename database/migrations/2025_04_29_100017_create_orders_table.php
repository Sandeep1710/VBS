<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            // status & payment_status use varchar instead of MySQL ENUM so we can
            // expand allowed values via later migrations without ALTER ENUM dance.
            $table->string('status', 30)->default('pending');
            $table->string('payment_status', 30)->default('pending');

            $table->string('billing_name', 120);
            $table->string('billing_phone', 20);
            $table->string('billing_email', 120)->nullable();
            $table->string('billing_line1', 180);
            $table->string('billing_line2', 180)->nullable();
            $table->string('billing_city', 80);
            $table->string('billing_state', 80);
            $table->string('billing_pincode', 10);
            $table->string('billing_country', 80)->default('India');

            $table->string('shipping_name', 120);
            $table->string('shipping_phone', 20);
            $table->string('shipping_line1', 180);
            $table->string('shipping_line2', 180)->nullable();
            $table->string('shipping_landmark', 180)->nullable();
            $table->string('shipping_city', 80);
            $table->string('shipping_state', 80);
            $table->string('shipping_pincode', 10);
            $table->string('shipping_country', 80)->default('India');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('exchange_discount', 10, 2)->default(0);
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->string('coupon_code', 40)->nullable();

            $table->enum('payment_method', ['cod', 'upi', 'card'])->default('cod');

            $table->boolean('exchange_pickup_required')->default(false);

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->text('notes')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
