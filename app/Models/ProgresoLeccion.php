<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoLeccion extends Model
{
    protected $table = 'progreso_lecciones';
    protected $primaryKey = 'id_progreso';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_leccion',
        'completada',
        'fecha_completada',
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_completada' => 'datetime',
    ];
}