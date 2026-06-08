<?php

namespace Tests\Feature;

use App\Models\LeccionEducativa;
use App\Models\ModuloEducativo;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_normal_user_cannot_open_admin_education_create_page(): void
    {
        $user = Usuario::factory()->create(['isadmin' => false]);

        $this->actingAs($user)
            ->get(route('modulos-educativos.create'))
            ->assertForbidden();
    }

    public function test_admin_can_open_admin_education_create_page(): void
    {
        $admin = Usuario::factory()->create(['isadmin' => true]);

        $this->actingAs($admin)
            ->get(route('modulos-educativos.create'))
            ->assertOk();
    }

    public function test_normal_user_can_read_education_content_but_cannot_edit_it(): void
    {
        $user = Usuario::factory()->create(['isadmin' => false]);
        $modulo = ModuloEducativo::create([
            'titulo' => 'Modulo de prueba',
            'descripcion' => 'Contenido educativo',
            'nivel' => 'basico',
            'duracion_minutos' => 0,
        ]);
        $leccion = LeccionEducativa::create([
            'id_modulo' => $modulo->id_modulo,
            'titulo' => 'Leccion de prueba',
            'contenido' => 'Contenido',
            'duracion_minutos' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('modulos-educativos.lecciones.show', [
                'modulo' => $modulo->id_modulo,
                'leccion' => $leccion->id_leccion,
            ]))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('modulos-educativos.lecciones.edit', [
                'modulo' => $modulo->id_modulo,
                'leccion' => $leccion->id_leccion,
            ]))
            ->assertForbidden();
    }

    public function test_admin_and_normal_user_keep_access_to_personal_modules(): void
    {
        $user = Usuario::factory()->create(['isadmin' => false]);
        $admin = Usuario::factory()->create(['isadmin' => true]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk();
    }
}
