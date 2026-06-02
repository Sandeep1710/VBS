<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop dependent tables first
        Schema::dropIfExists('installer_jobs');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('warehouses');

        // Migrate users: drop role_id FK + column, add is_admin if missing
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropForeign(['role_id']);
                } catch (\Throwable $e) {
                    // FK may not exist on SQLite or already dropped
                }
                $table->dropColumn('role_id');
            });
        }

        if (! Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false)->after('id');
                $table->index('is_admin');
            });
        }

        Schema::dropIfExists('roles');

        // Drop installation fields from orders
        Schema::table('orders', function (Blueprint $table) {
            foreach (['installation_required', 'installation_slot_at', 'installation_notes', 'installed_at'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // Drop installation_available from pincodes
        if (Schema::hasColumn('pincodes', 'installation_available')) {
            Schema::table('pincodes', function (Blueprint $table) {
                $table->dropColumn('installation_available');
            });
        }
    }

    public function down(): void
    {
        // Removed features — no rollback.
    }
};
