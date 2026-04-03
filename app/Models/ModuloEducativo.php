<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloEducativo extends Model
{
    protected $table = 'modulos_educativos';
    protected $primaryKey = 'id_modulo';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'nivel',
        'duracion_minutos',
    ];

    public function lecciones()
    {
        return $this->hasMany(LeccionEducativa::class, 'id_modulo', 'id_modulo');
    }

    public function getRouteKeyName()
    {
        return 'id_modulo';
    }
}