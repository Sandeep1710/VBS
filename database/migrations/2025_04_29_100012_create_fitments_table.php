<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_variant_id')->constrained('vehicle_variants')->cascadeOnDelete();
            $table->string('notes', 200)->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();

            $table->unique(['product_id', 'vehicle_variant_id']);
            $table->index('vehicle_variant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitments');
    }
};
