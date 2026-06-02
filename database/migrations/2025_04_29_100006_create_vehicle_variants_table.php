<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained('vehicle_models')->cascadeOnDelete();
            $table->string('name', 120);
            $table->enum('fuel_type', ['petrol', 'diesel', 'cng', 'electric', 'hybrid'])->nullable();
            $table->unsignedSmallInteger('year_from')->nullable();
            $table->unsignedSmallInteger('year_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['vehicle_model_id', 'fuel_type']);
            $table->index(['year_from', 'year_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_variants');
    }
};
