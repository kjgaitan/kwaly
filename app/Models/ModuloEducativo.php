<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa módulos de educación financiera.
 */
class ModuloEducativo extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'modulos_educativos';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_modulo';

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
        'titulo',
        'descripcion',
        'nivel',
        'duracion_minutos',
    ];

    /**
     * Relación con las lecciones del módulo.
     */
    public function lecciones()
    {
        return $this->hasMany(LeccionEducativa::class, 'id_modulo', 'id_modulo');
    }
}