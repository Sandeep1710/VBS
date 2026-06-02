<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label', 40)->default('Home');
            $table->string('name', 120);
            $table->string('phone', 20);
            $table->string('line1', 180);
            $table->string('line2', 180)->nullable();
            $table->string('landmark', 180)->nullable();
            $table->string('city', 80);
            $table->string('state', 80);
            $table->string('pincode', 10);
            $table->string('country', 80)->default('India');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
            $table->index('pincode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
