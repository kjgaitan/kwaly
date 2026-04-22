<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrupoMiembro extends Model
{
    protected $table = 'grupo_miembros';
    protected $primaryKey = 'id_miembro';
    public $timestamps = false;

    protected $fillable = [
        'id_grupo',
        'id_usuario',
        'rol',
        'fecha_union',
    ];

    protected function casts(): array
    {
        return [
            'fecha_union' => 'datetime',
        ];
    }

    /**
     * Grupo al que pertenece el miembro.
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(GrupoCompartido::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Usuario miembro del grupo.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}