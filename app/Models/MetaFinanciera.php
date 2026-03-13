<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa las metas financieras del usuario.
 */
class MetaFinanciera extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'metas_financieras';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_meta';

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
        'titulo',
        'descripcion',
        'monto_objetivo',
        'monto_actual',
        'fecha_inicio',
        'fecha_limite',
        'prioridad',
        'estado',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto_objetivo' => 'decimal:2',
            'monto_actual' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_limite' => 'date',
        ];
    }

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las aportaciones de la meta.
     */
    public function aportaciones()
    {
        return $this->hasMany(AportacionMeta::class, 'id_meta', 'id_meta');
    }
}