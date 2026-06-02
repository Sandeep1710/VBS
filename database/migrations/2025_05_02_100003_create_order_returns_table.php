<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('reason', 100);
            $table->text('details')->nullable();
            $table->string('status', 30)->default('requested');
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_returns');
    }
};
