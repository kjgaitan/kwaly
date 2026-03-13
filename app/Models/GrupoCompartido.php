<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa grupos de gastos compartidos.
 */
class GrupoCompartido extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'grupos_compartidos';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_grupo';

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
        'nombre_grupo',
        'descripcion',
        'creado_por',
        'fecha_creacion',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
        ];
    }

    /**
     * Relación con el usuario creador del grupo.
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por', 'id_usuario');
    }

    /**
     * Relación con los miembros del grupo.
     */
    public function miembros()
    {
        return $this->hasMany(GrupoMiembro::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Relación con los gastos compartidos del grupo.
     */
    public function gastos()
    {
        return $this->hasMany(GastoCompartido::class, 'id_grupo', 'id_grupo');
    }
}