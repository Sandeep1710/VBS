<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 120)->unique();
            $table->string('name', 120)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('source', 60)->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_token', 64)->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
