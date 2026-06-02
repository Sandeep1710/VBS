<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pincodes', function (Blueprint $table) {
            $table->id();
            $table->string('pincode', 10)->unique();
            $table->string('city', 80);
            $table->string('state', 80);
            $table->string('region', 80)->nullable();
            $table->boolean('is_serviceable')->default(true);
            $table->boolean('cod_available')->default(true);
            $table->decimal('delivery_charge', 8, 2)->default(0);
            $table->unsignedTinyInteger('expected_delivery_days')->default(3);
            $table->timestamps();

            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pincodes');
    }
};
