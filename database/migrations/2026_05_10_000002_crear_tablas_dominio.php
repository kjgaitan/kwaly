<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cuentas_financieras')) {
            Schema::create('cuentas_financieras', function (Blueprint $table) {
                $table->id('id_cuenta');
                $table->unsignedBigInteger('id_usuario');
                $table->string('nombre', 100);
                $table->enum('tipo_cuenta', ['efectivo', 'banco', 'tarjeta', 'ahorro', 'otro']);
                $table->decimal('saldo_actual', 12, 2)->default(0);
                $table->char('moneda', 3)->default('EUR');
            });
        }

        if (!Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->id('id_categoria');
                $table->unsignedBigInteger('id_usuario')->nullable();
                $table->string('nombre', 100);
                $table->string('icono', 100)->nullable();
                $table->char('color_hex', 7)->nullable();
            });
        }

        if (!Schema::hasTable('transacciones')) {
            Schema::create('transacciones', function (Blueprint $table) {
                $table->id('id_transaccion');
                $table->unsignedBigInteger('id_usuario');
                $table->unsignedBigInteger('id_cuenta');
                $table->unsignedBigInteger('id_categoria')->nullable();
                $table->enum('tipo_movimiento', ['ingreso', 'gasto']);
                $table->string('titulo', 150);
                $table->text('descripcion')->nullable();
                $table->decimal('monto', 12, 2);
                $table->dateTime('fecha_transaccion');
                $table->string('metodo_pago', 50)->nullable();
            });
        }

        if (!Schema::hasTable('presupuestos_mensuales')) {
            Schema::create('presupuestos_mensuales', function (Blueprint $table) {
                $table->id('id_presupuesto');
                $table->unsignedBigInteger('id_usuario');
                $table->integer('anio');
                $table->integer('mes');
                $table->decimal('ingreso_estimado', 12, 2);
                $table->decimal('porcentaje_necesidades', 5, 2)->default(50);
                $table->decimal('porcentaje_deseos', 5, 2)->default(30);
                $table->decimal('porcentaje_ahorro', 5, 2)->default(20);
            });
        }

        if (!Schema::hasTable('presupuesto_detalle_categoria')) {
            Schema::create('presupuesto_detalle_categoria', function (Blueprint $table) {
                $table->id('id_detalle');
                $table->unsignedBigInteger('id_presupuesto');
                $table->unsignedBigInteger('id_categoria')->nullable();
                $table->enum('tipo_presupuesto', ['necesidades', 'deseos', 'ahorro']);
                $table->decimal('limite_monto', 12, 2);
                $table->decimal('monto_gastado', 12, 2)->default(0);
            });
        }

        if (!Schema::hasTable('metas_financieras')) {
            Schema::create('metas_financieras', function (Blueprint $table) {
                $table->id('id_meta');
                $table->unsignedBigInteger('id_usuario');
                $table->string('titulo', 150);
                $table->text('descripcion')->nullable();
                $table->decimal('monto_objetivo', 12, 2);
                $table->decimal('monto_actual', 12, 2)->default(0);
                $table->date('fecha_inicio')->nullable();
                $table->date('fecha_limite')->nullable();
                $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
                $table->enum('estado', ['activa', 'completada', 'pausada'])->default('activa');
            });
        }

        if (!Schema::hasTable('aportaciones_meta')) {
            Schema::create('aportaciones_meta', function (Blueprint $table) {
                $table->id('id_aportacion');
                $table->unsignedBigInteger('id_meta');
                $table->decimal('monto', 12, 2);
                $table->dateTime('fecha_aportacion');
                $table->string('comentario', 255)->nullable();
            });
        }

        if (!Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->id('id_factura');
                $table->unsignedBigInteger('id_usuario');
                $table->string('proveedor', 150);
                $table->string('concepto', 150);
                $table->text('descripcion')->nullable();
                $table->decimal('monto_total', 12, 2);
                $table->date('fecha_vencimiento');
                $table->date('fecha_pago')->nullable();
                $table->enum('estado', ['pendiente', 'pagada', 'vencida'])->default('pendiente');
                $table->enum('frecuencia', ['unica', 'mensual', 'anual'])->default('unica');
            });
        }

        if (!Schema::hasTable('modulos_educativos')) {
            Schema::create('modulos_educativos', function (Blueprint $table) {
                $table->id('id_modulo');
                $table->string('titulo', 150);
                $table->text('descripcion')->nullable();
                $table->enum('nivel', ['basico', 'intermedio', 'avanzado'])->default('basico');
                $table->integer('duracion_minutos')->default(0);
            });
        }

        if (!Schema::hasTable('lecciones_educativas')) {
            Schema::create('lecciones_educativas', function (Blueprint $table) {
                $table->id('id_leccion');
                $table->unsignedBigInteger('id_modulo');
                $table->string('titulo', 150);
                $table->text('contenido');
                $table->integer('duracion_minutos')->default(0);
            });
        }

        if (!Schema::hasTable('progreso_lecciones')) {
            Schema::create('progreso_lecciones', function (Blueprint $table) {
                $table->id('id_progreso');
                $table->unsignedBigInteger('id_usuario');
                $table->unsignedBigInteger('id_leccion');
                $table->boolean('completada')->default(false);
                $table->dateTime('fecha_completada')->nullable();
            });
        }

        if (!Schema::hasTable('configuracion_usuario')) {
            Schema::create('configuracion_usuario', function (Blueprint $table) {
                $table->id('id_configuracion');
                $table->unsignedBigInteger('id_usuario');
                $table->boolean('notificacion_email')->default(true);
                $table->boolean('notificacion_push')->default(true);
                $table->boolean('alerta_presupuesto')->default(true);
                $table->boolean('recordatorio_pagos')->default(true);
                $table->boolean('autenticacion_2fa')->default(false);
            });
        }

        if (!Schema::hasTable('grupos_compartidos')) {
            Schema::create('grupos_compartidos', function (Blueprint $table) {
                $table->id('id_grupo');
                $table->string('nombre_grupo', 100);
                $table->string('descripcion', 255)->nullable();
                $table->unsignedBigInteger('creado_por');
                $table->dateTime('fecha_creacion');
            });
        }

        if (!Schema::hasTable('grupo_miembros')) {
            Schema::create('grupo_miembros', function (Blueprint $table) {
                $table->id('id_miembro');
                $table->unsignedBigInteger('id_grupo');
                $table->unsignedBigInteger('id_usuario');
                $table->enum('rol', ['admin', 'miembro'])->default('miembro');
                $table->dateTime('fecha_union');
            });
        }

        if (!Schema::hasTable('gastos_compartidos')) {
            Schema::create('gastos_compartidos', function (Blueprint $table) {
                $table->id('id_gasto');
                $table->unsignedBigInteger('id_grupo');
                $table->unsignedBigInteger('id_usuario_pagador');
                $table->string('titulo', 150);
                $table->string('categoria', 50)->nullable();
                $table->string('descripcion', 255)->nullable();
                $table->decimal('monto_total', 12, 2);
                $table->dateTime('fecha_gasto');
            });
        }

        if (!Schema::hasTable('chat_asistente')) {
            Schema::create('chat_asistente', function (Blueprint $table) {
                $table->id('id_chat');
                $table->unsignedBigInteger('id_usuario');
                $table->string('titulo_chat', 150);
                $table->dateTime('fecha_creacion');
            });
        }

        if (!Schema::hasTable('mensajes_asistente')) {
            Schema::create('mensajes_asistente', function (Blueprint $table) {
                $table->id('id_mensaje');
                $table->unsignedBigInteger('id_chat');
                $table->enum('emisor', ['usuario', 'asistente']);
                $table->text('mensaje');
                $table->dateTime('fecha_envio');
            });
        }
    }

    public function down(): void
    {
        foreach ([
            'mensajes_asistente',
            'chat_asistente',
            'gastos_compartidos',
            'grupo_miembros',
            'grupos_compartidos',
            'configuracion_usuario',
            'progreso_lecciones',
            'lecciones_educativas',
            'modulos_educativos',
            'facturas',
            'aportaciones_meta',
            'metas_financieras',
            'presupuesto_detalle_categoria',
            'presupuestos_mensuales',
            'transacciones',
            'categorias',
            'cuentas_financieras',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
