<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_product_records_audit(): void
    {
        $user = $this->makeCustomer();
        $this->actingAs($user);

        $product = $this->makeProduct(['name' => 'Audit Test']);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'created',
            'auditable_type' => $product::class,
            'auditable_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_updating_a_product_records_changed_fields(): void
    {
        $user = $this->makeCustomer();
        $this->actingAs($user);

        $product = $this->makeProduct();
        AuditLog::query()->delete();

        $product->update(['price' => 9999]);

        $log = AuditLog::where('event', 'updated')
            ->where('auditable_id', $product->id)
            ->first();

        $this->assertNotNull($log);
        $this->assertArrayHasKey('price', $log->new_values);
        $this->assertArrayHasKey('price', $log->old_values);
    }

    public function test_views_count_change_does_not_record_audit(): void
    {
        $product = $this->makeProduct();
        AuditLog::query()->delete();

        $product->increment('views_count');

        $this->assertDatabaseCount('audit_logs', 0);
    }

    public function test_deleting_a_coupon_records_audit(): void
    {
        $coupon = Coupon::create([
            'code' => 'AUDIT', 'name' => 'Audit', 'type' => 'flat',
            'value' => 100, 'is_active' => true,
        ]);
        AuditLog::query()->delete();

        $coupon->delete();

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'deleted',
            'auditable_id' => $coupon->id,
        ]);
    }
}
