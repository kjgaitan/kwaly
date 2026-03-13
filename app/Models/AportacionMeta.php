<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa las aportaciones realizadas a una meta financiera.
 */
class AportacionMeta extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'aportaciones_meta';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_aportacion';

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
        'id_meta',
        'monto',
        'fecha_aportacion',
        'comentario',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_aportacion' => 'datetime',
        ];
    }

    /**
     * Relación con la meta financiera.
     */
    public function meta()
    {
        return $this->belongsTo(MetaFinanciera::class, 'id_meta', 'id_meta');
    }
}