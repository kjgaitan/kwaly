<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeccionEducativa extends Model
{
    protected $table = 'lecciones_educativas';
    protected $primaryKey = 'id_leccion';
    public $timestamps = false;

    protected $fillable = [
        'id_modulo',
        'titulo',
        'contenido',
        'duracion_minutos',
    ];

    public function modulo()
    {
        return $this->belongsTo(ModuloEducativo::class, 'id_modulo', 'id_modulo');
    }

    public function progreso()
    {
        return $this->hasMany(ProgresoLeccion::class, 'id_leccion', 'id_leccion');
    }

    public function getRouteKeyName()
    {
        return 'id_leccion';
    }
}