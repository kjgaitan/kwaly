<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AportacionMeta extends Model
{
    protected $table = 'aportaciones_meta';
    protected $primaryKey = 'id_aportacion';
    public $timestamps = false;

    protected $fillable = [
        'id_meta',
        'monto',
        'fecha_aportacion',
        'comentario',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_aportacion' => 'datetime',
    ];
}