<?php

namespace App\Services;

use App\Models\ConfiguracionUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Servicio encargado de la lógica de configuración del usuario.
 */
class ConfiguracionService
{
    /**
     * Obtiene la configuración del usuario o la crea si no existe.
     */
    public function obtenerConfiguracion(int $idUsuario): ConfiguracionUsuario
    {
        return ConfiguracionUsuario::firstOrCreate(
            ['id_usuario' => $idUsuario],
            [
                'notificacion_email' => true,
                'notificacion_push' => true,
                'alerta_presupuesto' => true,
                'recordatorio_pagos' => true,
                'autenticacion_2fa' => false,
            ]
        );
    }

    /**
     * Actualiza los datos básicos del perfil.
     */
    public function actualizarPerfil(Usuario $usuario, array $datos): void
    {
        $usuario->update([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
        ]);
    }

    /**
     * Actualiza la moneda preferida del usuario.
     */
    public function actualizarMoneda(Usuario $usuario, array $datos): void
    {
        $usuario->update([
            'moneda_preferida' => $datos['moneda_preferida'],
        ]);
    }

    /**
     * Actualiza únicamente las notificaciones.
     */
    public function actualizarNotificaciones(ConfiguracionUsuario $configuracion, array $datos): void
    {
        $configuracion->update([
            'notificacion_email' => (bool) ($datos['notificacion_email'] ?? false),
            'notificacion_push' => (bool) ($datos['notificacion_push'] ?? false),
            'alerta_presupuesto' => (bool) ($datos['alerta_presupuesto'] ?? false),
            'recordatorio_pagos' => (bool) ($datos['recordatorio_pagos'] ?? false),
        ]);
    }

    /**
     * Actualiza únicamente la seguridad del usuario.
     */
    public function actualizarSeguridad(ConfiguracionUsuario $configuracion, array $datos): void
    {
        $configuracion->update([
            'autenticacion_2fa' => (bool) ($datos['autenticacion_2fa'] ?? false),
        ]);
    }

    /**
     * Actualiza la contraseña del usuario.
     */
    public function actualizarPassword(Usuario $usuario, array $datos): void
    {
        if (!Hash::check($datos['password_actual'], $usuario->password_hash)) {
            throw ValidationException::withMessages([
                'password_actual' => __('messages.configuracion.password_actual_incorrecta'),
            ]);
        }

        $usuario->update([
            'password_hash' => Hash::make($datos['password_nueva']),
        ]);
    }

    /**
     * Obtiene todos los datos principales del usuario para exportación.
     */
    public function obtenerDatosExportacion(Usuario $usuario): array
    {
        $usuario->load([
            'configuracion',
            'categorias',
            'cuentas',
            'transacciones',
            'presupuestos.detalles',
            'facturas',
            'metas.aportaciones',
            'progresosLecciones',
            'chats.mensajes',
            'gruposCreados.miembros',
            'gruposCreados.gastos',
            'grupoMiembros',
            'gastosCompartidosPagados',
        ]);

        return [
            'usuario' => $usuario->only([
                'id_usuario',
                'nombre',
                'email',
                'telefono',
                'moneda_preferida',
                'estado_cuenta',
                'fecha_registro',
                'ultimo_acceso',
            ]),
            'configuracion' => $usuario->configuracion,
            'categorias' => $usuario->categorias,
            'cuentas' => $usuario->cuentas,
            'transacciones' => $usuario->transacciones,
            'presupuestos' => $usuario->presupuestos,
            'facturas' => $usuario->facturas,
            'metas' => $usuario->metas,
            'progreso_lecciones' => $usuario->progresosLecciones,
            'chats' => $usuario->chats,
            'grupos_creados' => $usuario->gruposCreados,
            'grupo_miembros' => $usuario->grupoMiembros,
            'gastos_compartidos_pagados' => $usuario->gastosCompartidosPagados,
        ];
    }

    /**
     * Elimina por completo la cuenta del usuario y sus datos asociados.
     */
    public function eliminarCuentaUsuario(Usuario $usuario, string $passwordConfirmacion): void
    {
        if (!Hash::check($passwordConfirmacion, $usuario->password_hash)) {
            throw ValidationException::withMessages([
                'password_confirmacion' => __('messages.configuracion.password_confirmacion_incorrecta'),
            ]);
        }

        DB::transaction(function () use ($usuario) {
            $usuario->load([
                'configuracion',
                'metas.aportaciones',
                'presupuestos.detalles',
                'chats.mensajes',
                'gruposCreados.miembros',
                'gruposCreados.gastos',
                'grupoMiembros',
                'gastosCompartidosPagados',
                'progresosLecciones',
                'transacciones',
                'facturas',
                'cuentas',
                'categorias',
            ]);

            if ($usuario->configuracion) {
                $usuario->configuracion()->delete();
            }

            foreach ($usuario->metas as $meta) {
                $meta->aportaciones()->delete();
            }
            $usuario->metas()->delete();

            foreach ($usuario->presupuestos as $presupuesto) {
                $presupuesto->detalles()->delete();
            }
            $usuario->presupuestos()->delete();

            foreach ($usuario->chats as $chat) {
                $chat->mensajes()->delete();
            }
            $usuario->chats()->delete();

            foreach ($usuario->gruposCreados as $grupo) {
                $grupo->miembros()->delete();
                $grupo->gastos()->delete();
            }
            $usuario->gruposCreados()->delete();

            $usuario->grupoMiembros()->delete();
            $usuario->gastosCompartidosPagados()->delete();
            $usuario->progresosLecciones()->delete();
            $usuario->transacciones()->delete();
            $usuario->facturas()->delete();
            $usuario->cuentas()->delete();
            $usuario->categorias()->delete();

            $usuario->delete();
        });
    }
}