<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
    }

    public function down(): void
    {
        // Blog feature removed — no rollback.
    }
};
