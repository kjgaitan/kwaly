<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GastoCompartido extends Model
{
    protected $table = 'gastos_compartidos';
    protected $primaryKey = 'id_gasto';
    public $timestamps = false;

    protected $fillable = [
        'id_grupo',
        'id_usuario_pagador',
        'titulo',
        'categoria',
        'descripcion',
        'monto_total',
        'fecha_gasto',
    ];

    protected function casts(): array
    {
        return [
            'monto_total' => 'decimal:2',
            'fecha_gasto' => 'datetime',
        ];
    }

    /**
     * Grupo al que pertenece el gasto.
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(GrupoCompartido::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Usuario que pagó el gasto.
     */
    public function pagador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_pagador', 'id_usuario');
    }
}
