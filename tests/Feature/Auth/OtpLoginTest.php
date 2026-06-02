<?php

namespace Tests\Feature\Auth;

use App\Models\OtpCode;
use App\Services\Otp\OtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OtpLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_otp_creates_code_for_existing_user(): void
    {
        $user = $this->makeCustomer(['email' => 'otp@example.test']);

        $this->post('/otp', ['identifier' => 'otp@example.test', 'channel' => 'email'])
            ->assertRedirect();

        $this->assertDatabaseHas('otp_codes', [
            'identifier' => 'otp@example.test',
            'channel' => 'email',
            'purpose' => OtpCode::PURPOSE_LOGIN,
        ]);
    }

    public function test_send_otp_rejects_unknown_user(): void
    {
        $this->post('/otp', ['identifier' => 'nope@example.test', 'channel' => 'email'])
            ->assertSessionHasErrors('identifier');

        $this->assertDatabaseCount('otp_codes', 0);
    }

    public function test_otp_verify_logs_user_in(): void
    {
        $user = $this->makeCustomer(['email' => 'verify@example.test']);

        // Generate OTP and read it from DB (we know the code we wrote)
        OtpCode::create([
            'identifier' => 'verify@example.test',
            'channel' => 'email',
            'code_hash' => Hash::make('123456'),
            'purpose' => OtpCode::PURPOSE_LOGIN,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->post('/otp/verify', [
            'identifier' => 'verify@example.test',
            'channel' => 'email',
            'code' => '123456',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_otp_rejected(): void
    {
        $this->makeCustomer(['email' => 'bad@example.test']);
        OtpCode::create([
            'identifier' => 'bad@example.test',
            'channel' => 'email',
            'code_hash' => Hash::make('111111'),
            'purpose' => OtpCode::PURPOSE_LOGIN,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->post('/otp/verify', [
            'identifier' => 'bad@example.test',
            'channel' => 'email',
            'code' => '999999',
        ])->assertSessionHasErrors('code');

        $this->assertGuest();
    }

    public function test_expired_otp_rejected(): void
    {
        $this->makeCustomer(['email' => 'expired@example.test']);
        OtpCode::create([
            'identifier' => 'expired@example.test',
            'channel' => 'email',
            'code_hash' => Hash::make('123456'),
            'purpose' => OtpCode::PURPOSE_LOGIN,
            'expires_at' => now()->subMinutes(5),
        ]);

        $this->post('/otp/verify', [
            'identifier' => 'expired@example.test',
            'channel' => 'email',
            'code' => '123456',
        ])->assertSessionHasErrors('code');
    }

    public function test_api_otp_send_and_verify_returns_token(): void
    {
        $user = $this->makeCustomer(['email' => 'api-otp@example.test']);

        OtpCode::create([
            'identifier' => 'api-otp@example.test',
            'channel' => 'email',
            'code_hash' => Hash::make('246810'),
            'purpose' => OtpCode::PURPOSE_LOGIN,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->postJson('/api/v1/auth/otp/verify', [
            'identifier' => 'api-otp@example.test',
            'code' => '246810',
        ])->assertOk()
          ->assertJsonStructure(['token', 'user']);
    }

    public function test_email_gets_verified_on_successful_otp_login(): void
    {
        $user = $this->makeCustomer(['email' => 'unv@example.test'], verified: false);
        $this->assertNull($user->fresh()->email_verified_at);

        OtpCode::create([
            'identifier' => 'unv@example.test',
            'channel' => 'email',
            'code_hash' => Hash::make('123456'),
            'purpose' => OtpCode::PURPOSE_LOGIN,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->post('/otp/verify', [
            'identifier' => 'unv@example.test',
            'channel' => 'email',
            'code' => '123456',
        ]);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
