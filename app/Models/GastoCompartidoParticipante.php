<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GastoCompartidoParticipante extends Model
{
    protected $table = 'gasto_compartido_participantes';
    protected $primaryKey = 'id_participante';
    public $timestamps = false;

    protected $fillable = [
        'id_gasto',
        'id_usuario',
    ];

    public function gasto(): BelongsTo
    {
        return $this->belongsTo(GastoCompartido::class, 'id_gasto', 'id_gasto');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
