<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo que representa la configuración personalizada de un usuario.
 */
class ConfiguracionUsuario extends Model
{
    /**
     * Nombre de la tabla asociada.
     */
    protected $table = 'configuracion_usuario';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_configuracion';

    /**
     * Laravel no gestionará timestamps automáticos.
     */
    public $timestamps = false;

    /**
     * Campos asignables de forma masiva.
     */
    protected $fillable = [
        'id_usuario',
        'notificacion_email',
        'notificacion_push',
        'alerta_presupuesto',
        'recordatorio_pagos',
        'autenticacion_2fa',
    ];

    /**
     * Conversión de tipos.
     */
    protected $casts = [
        'notificacion_email' => 'boolean',
        'notificacion_push' => 'boolean',
        'alerta_presupuesto' => 'boolean',
        'recordatorio_pagos' => 'boolean',
        'autenticacion_2fa' => 'boolean',
    ];

    /**
     * Relación con el usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}