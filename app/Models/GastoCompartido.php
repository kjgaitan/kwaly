<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa los gastos realizados dentro de un grupo compartido.
 */
class GastoCompartido extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'gastos_compartidos';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_gasto';

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
        'id_grupo',
        'id_usuario_pagador',
        'titulo',
        'monto_total',
        'fecha_gasto',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto_total' => 'decimal:2',
            'fecha_gasto' => 'datetime',
        ];
    }

    /**
     * Relación con el grupo compartido.
     */
    public function grupo()
    {
        return $this->belongsTo(GrupoCompartido::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Relación con el usuario que pagó el gasto.
     */
    public function pagador()
    {
        return $this->belongsTo(User::class, 'id_usuario_pagador', 'id_usuario');
    }
}