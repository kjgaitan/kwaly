<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrupoCompartido extends Model
{
    protected $table = 'grupos_compartidos';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;

    protected $fillable = [
        'nombre_grupo',
        'descripcion',
        'creado_por',
        'fecha_creacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
        ];
    }

    /**
     * Usuario creador del grupo.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'creado_por', 'id_usuario');
    }

    /**
     * Miembros del grupo.
     */
    public function miembros(): HasMany
    {
        return $this->hasMany(GrupoMiembro::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Gastos compartidos del grupo.
     */
    public function gastos(): HasMany
    {
        return $this->hasMany(GastoCompartido::class, 'id_grupo', 'id_grupo');
    }
}