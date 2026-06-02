<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->cascadeOnDelete();
            $table->foreignId('vehicle_brand_id')->constrained('vehicle_brands')->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('slug', 140);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['vehicle_type_id', 'vehicle_brand_id', 'slug']);
            $table->index(['vehicle_type_id', 'vehicle_brand_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_models');
    }
};
