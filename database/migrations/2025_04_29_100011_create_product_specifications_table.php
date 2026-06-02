<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('group', 80)->nullable();
            $table->string('key', 120);
            $table->string('value', 255);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'group']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
    }
};
