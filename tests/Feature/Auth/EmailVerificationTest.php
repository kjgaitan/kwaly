<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_verified_email_route_redirects_to_dashboard(): void
    {
        $user = Usuario::factory()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id_usuario, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
    }

    public function test_email_verification_rejects_invalid_hash(): void
    {
        $user = Usuario::factory()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id_usuario, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertForbidden();
    }
}
