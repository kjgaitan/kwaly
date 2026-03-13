<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la configuración personalizada del usuario.
 */
class ConfiguracionUsuario extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'configuracion_usuario';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_configuracion';

    /**
     * No se usan timestamps automáticos.
     */
    public $timestamps = false;

    /**
     * Campos asignables de forma masiva.
     *
     * @var list<string>
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
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'notificacion_email' => 'boolean',
            'notificacion_push' => 'boolean',
            'alerta_presupuesto' => 'boolean',
            'recordatorio_pagos' => 'boolean',
            'autenticacion_2fa' => 'boolean',
        ];
    }

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}