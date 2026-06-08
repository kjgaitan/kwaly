<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo que representa a los usuarios del sistema.
 */
class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla asociada.
     */
    protected $table = 'usuarios';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Real password column in the usuarios table.
     */
    protected $authPasswordName = 'password_hash';

    /**
     * The usuarios table does not have a remember_token column.
     */
    protected $rememberTokenName = '';

    /**
     * Laravel no gestionará timestamps automáticos.
     */
    public $timestamps = false;

    /**
     * Campos asignables de forma masiva.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'telefono',
        'moneda_preferida',
        'idioma_preferido',
        'estado_cuenta',
        'isadmin',
        'fecha_registro',
        'ultimo_acceso',
    ];

    /**
     * Campos ocultos en serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_registro' => 'datetime',
            'ultimo_acceso' => 'datetime',
            'isadmin' => 'boolean',
        ];
    }

    /**
     * Devuelve el campo de contraseña usado por Laravel.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getIdAttribute()
    {
        return $this->id_usuario;
    }

    public function getNameAttribute()
    {
        return $this->nombre;
    }

    public function getPasswordAttribute()
    {
        return $this->password_hash;
    }

    public function isAdmin(): bool
    {
        return (bool) $this->isadmin;
    }

    public function hasVerifiedEmail()
    {
        return true;
    }

    public function markEmailAsVerified()
    {
        return true;
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Relación con la configuración del usuario.
     */
    public function configuracion()
    {
        return $this->hasOne(ConfiguracionUsuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las categorías creadas por el usuario.
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las cuentas financieras del usuario.
     */
    public function cuentas()
    {
        return $this->hasMany(CuentaFinanciera::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las transacciones del usuario.
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con los presupuestos mensuales del usuario.
     */
    public function presupuestos()
    {
        return $this->hasMany(PresupuestoMensual::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las facturas del usuario.
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las metas financieras del usuario.
     */
    public function metas()
    {
        return $this->hasMany(MetaFinanciera::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con el progreso de lecciones del usuario.
     */
    public function progresosLecciones()
    {
        return $this->hasMany(ProgresoLeccion::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con los grupos compartidos creados por el usuario.
     */
    public function gruposCreados()
    {
        return $this->hasMany(GrupoCompartido::class, 'creado_por', 'id_usuario');
    }

    /**
     * Relación con las participaciones del usuario en grupos.
     */
    public function grupoMiembros()
    {
        return $this->hasMany(GrupoMiembro::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con los gastos compartidos pagados por el usuario.
     */
    public function gastosCompartidosPagados()
    {
        return $this->hasMany(GastoCompartido::class, 'id_usuario_pagador', 'id_usuario');
    }
}
