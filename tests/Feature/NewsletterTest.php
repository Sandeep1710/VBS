<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_subscribe(): void
    {
        $this->post('/newsletter/subscribe', ['email' => 'fan@example.test'])
            ->assertRedirect();

        $sub = NewsletterSubscriber::where('email', 'fan@example.test')->first();
        $this->assertNotNull($sub);
        $this->assertTrue($sub->is_active);
        $this->assertNotEmpty($sub->unsubscribe_token);
    }

    public function test_invalid_email_rejected(): void
    {
        $this->from('/')
            ->post('/newsletter/subscribe', ['email' => 'not-an-email'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }

    public function test_resubscribe_reactivates(): void
    {
        $sub = NewsletterSubscriber::create([
            'email' => 'come@example.test',
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        $this->post('/newsletter/subscribe', ['email' => 'come@example.test']);

        $fresh = $sub->fresh();
        $this->assertTrue($fresh->is_active);
        $this->assertNull($fresh->unsubscribed_at);
    }

    public function test_unsubscribe_with_token(): void
    {
        $sub = NewsletterSubscriber::create([
            'email' => 'bye@example.test',
            'is_active' => true,
        ]);

        $this->get("/newsletter/unsubscribe/{$sub->unsubscribe_token}")
            ->assertOk()
            ->assertSee('unsubscribed');

        $this->assertFalse($sub->fresh()->is_active);
    }
}
