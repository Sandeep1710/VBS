<?php

namespace Tests\Feature;

use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase9eTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_redirect_is_followed_with_correct_status_code(): void
    {
        Redirect::create([
            'from_path' => '/old-page',
            'to_path' => '/products',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $this->get('/old-page')
            ->assertStatus(301)
            ->assertRedirect('/products');
    }

    public function test_inactive_redirect_is_ignored(): void
    {
        Redirect::create([
            'from_path' => '/disabled',
            'to_path' => '/products',
            'status_code' => 301,
            'is_active' => false,
        ]);

        // Without a real route at /disabled, Laravel returns 404 — which is what
        // we want to confirm: the redirect did not fire.
        $this->get('/disabled')->assertStatus(404);
    }

    public function test_redirect_hits_counter_increments(): void
    {
        $r = Redirect::create([
            'from_path' => '/promo-2024',
            'to_path' => '/products',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $this->get('/promo-2024');
        $this->get('/promo-2024');

        $this->assertEquals(2, $r->fresh()->hits);
    }
}
