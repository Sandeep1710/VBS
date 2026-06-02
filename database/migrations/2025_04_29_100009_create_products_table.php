<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battery_brand_id')->constrained('battery_brands')->restrictOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->string('sku', 60)->unique();
            $table->decimal('capacity_ah', 8, 2)->nullable();
            $table->decimal('voltage', 5, 2)->nullable();
            $table->unsignedSmallInteger('warranty_months')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('exchange_available')->default(false);
            $table->decimal('exchange_discount', 8, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(5);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('sales_count')->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_featured']);
            $table->index('category_id');
            $table->index('battery_brand_id');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
