<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropIndex(['is_admin']);
                } catch (\Throwable $e) {
                    // Index may not exist
                }
                $table->dropColumn('is_admin');
            });
        }
    }

    public function down(): void
    {
        // Admin module removed — no rollback.
    }
};
