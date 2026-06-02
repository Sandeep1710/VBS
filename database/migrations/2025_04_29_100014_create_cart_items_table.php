<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->boolean('exchange_old_battery')->default(false);
            $table->decimal('exchange_discount', 10, 2)->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['cart_id', 'product_id', 'exchange_old_battery'], 'cart_items_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
