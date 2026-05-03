<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_configuracion_page_is_displayed(): void
    {
        $user = Usuario::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/configuracion');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated_from_configuracion(): void
    {
        $user = Usuario::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/configuracion/perfil', [
                'nombre' => 'Test User',
                'email' => 'test@example.com',
                'telefono' => '600123123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('configuracion.index', absolute: false));

        $user->refresh();

        $this->assertSame('Test User', $user->nombre);
        $this->assertSame('test@example.com', $user->email);
        $this->assertSame('600123123', $user->telefono);
    }

    public function test_profile_information_can_keep_the_same_email(): void
    {
        $user = Usuario::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/configuracion/perfil', [
                'nombre' => 'Test User',
                'email' => $user->email,
                'telefono' => null,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('configuracion.index', absolute: false));

        $this->assertSame($user->email, $user->refresh()->email);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = Usuario::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/configuracion/eliminar-cuenta', [
                'password_confirmacion' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = Usuario::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/configuracion')
            ->delete('/configuracion/eliminar-cuenta', [
                'password_confirmacion' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password_confirmacion')
            ->assertRedirect('/configuracion');

        $this->assertNotNull($user->fresh());
    }
}
