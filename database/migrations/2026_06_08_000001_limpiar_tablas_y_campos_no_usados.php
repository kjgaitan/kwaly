<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'role_has_permissions',
            'model_has_roles',
            'model_has_permissions',
            'permissions',
            'roles',
            'mensajes_asistente',
            'chat_asistente',
            'restablecimiento_contrasenas',
            'password_reset_tokens',
            'sessions',
            'cache_locks',
            'cache',
            'job_batches',
            'failed_jobs',
            'jobs',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        if (Schema::hasTable('configuracion_usuario')) {
            Schema::table('configuracion_usuario', function (Blueprint $table) {
                if (Schema::hasColumn('configuracion_usuario', 'notificacion_push')) {
                    $table->dropColumn('notificacion_push');
                }

                if (Schema::hasColumn('configuracion_usuario', 'autenticacion_2fa')) {
                    $table->dropColumn('autenticacion_2fa');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('configuracion_usuario')) {
            Schema::table('configuracion_usuario', function (Blueprint $table) {
                if (!Schema::hasColumn('configuracion_usuario', 'notificacion_push')) {
                    $table->boolean('notificacion_push')->default(true)->after('notificacion_email');
                }

                if (!Schema::hasColumn('configuracion_usuario', 'autenticacion_2fa')) {
                    $table->boolean('autenticacion_2fa')->default(false)->after('recordatorio_pagos');
                }
            });
        }
    }
};
