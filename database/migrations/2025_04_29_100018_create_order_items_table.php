<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name', 200);
            $table->string('product_sku', 60);
            $table->string('product_brand', 80)->nullable();
            $table->string('product_image')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->boolean('exchange_old_battery')->default(false);
            $table->decimal('exchange_discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedSmallInteger('warranty_months')->default(0);
            $table->date('warranty_starts_at')->nullable();
            $table->date('warranty_ends_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
