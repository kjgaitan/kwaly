<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\LeccionEducativa;
use App\Models\ModuloEducativo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario::factory(10)->create();

        Usuario::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nombre' => 'Admin User',
                'password_hash' => Hash::make('password'),
                'moneda_preferida' => 'EUR',
                'idioma_preferido' => 'es',
                'estado_cuenta' => 'activo',
                'isadmin' => true,
                'fecha_registro' => now(),
                'ultimo_acceso' => now(),
            ]
        );

        Usuario::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'nombre' => 'Test User',
                'password_hash' => Hash::make('password'),
                'moneda_preferida' => 'EUR',
                'idioma_preferido' => 'es',
                'estado_cuenta' => 'activo',
                'isadmin' => false,
                'fecha_registro' => now(),
                'ultimo_acceso' => now(),
            ]
        );

        $modulo = ModuloEducativo::firstOrCreate(
            ['titulo' => 'Finanzas personales basicas'],
            [
                'descripcion' => 'Aprende conceptos esenciales para controlar tu dinero, organizar gastos y crear habitos financieros sostenibles.',
                'nivel' => 'basico',
                'duracion_minutos' => 0,
            ]
        );

        $lecciones = [
            [
                'titulo' => 'Conoce tus ingresos y gastos',
                'contenido' => 'Antes de tomar decisiones financieras, identifica cuanto dinero entra cada mes y en que se va. Clasifica tus gastos entre necesarios, deseos y ahorro para tener una vision clara de tu situacion.',
                'duracion_minutos' => 5,
            ],
            [
                'titulo' => 'Crea un presupuesto simple',
                'contenido' => 'Un presupuesto te ayuda a decidir por adelantado como usar tu dinero. Define limites realistas para tus categorias principales y revisalos cada semana para hacer ajustes a tiempo.',
                'duracion_minutos' => 6,
            ],
            [
                'titulo' => 'Empieza con una meta pequena',
                'contenido' => 'Elige una meta alcanzable, como ahorrar una cantidad fija para emergencias. Registrar el avance mantiene la motivacion y convierte el ahorro en un habito.',
                'duracion_minutos' => 4,
            ],
        ];

        foreach ($lecciones as $leccion) {
            LeccionEducativa::firstOrCreate(
                [
                    'id_modulo' => $modulo->id_modulo,
                    'titulo' => $leccion['titulo'],
                ],
                $leccion
            );
        }
    }
}
