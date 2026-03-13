<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una lección educativa dentro de un módulo.
 */
class LeccionEducativa extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'lecciones_educativas';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_leccion';

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
        'id_modulo',
        'titulo',
        'contenido',
        'duracion_minutos',
    ];

    /**
     * Relación con el módulo educativo.
     */
    public function modulo()
    {
        return $this->belongsTo(ModuloEducativo::class, 'id_modulo', 'id_modulo');
    }
}