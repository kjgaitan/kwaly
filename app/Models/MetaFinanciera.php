<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetaFinanciera extends Model
{
    protected $table = 'metas_financieras';
    protected $primaryKey = 'id_meta';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'titulo',
        'descripcion',
        'monto_objetivo',
        'fecha_inicio',
        'fecha_limite',
        'prioridad',
        'estado',
    ];

    protected $casts = [
        'monto_objetivo' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_limite' => 'date',
    ];

    /**
     * Relación con aportaciones
     */
    public function aportaciones(): HasMany
    {
        return $this->hasMany(AportacionMeta::class, 'id_meta', 'id_meta');
    }
}