<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la participación de usuarios en grupos compartidos.
 */
class GrupoMiembro extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'grupo_miembros';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_miembro';

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
        'id_usuario',
        'rol',
        'fecha_union',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_union' => 'datetime',
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
     * Relación con el usuario miembro.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}