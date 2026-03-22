<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PresupuestoDetalleCategoria;
use App\Models\User;

class PresupuestoMensual extends Model
{
    use HasFactory;

    protected $table = 'presupuestos_mensuales';
    protected $primaryKey = 'id_presupuesto';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'anio',
        'mes',
        'ingreso_estimado',
        'porcentaje_necesidades',
        'porcentaje_deseos',
        'porcentaje_ahorro',
    ];

    protected function casts(): array
    {
        return [
            'ingreso_estimado' => 'decimal:2',
            'porcentaje_necesidades' => 'decimal:2',
            'porcentaje_deseos' => 'decimal:2',
            'porcentaje_ahorro' => 'decimal:2',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(PresupuestoDetalleCategoria::class, 'id_presupuesto', 'id_presupuesto');
    }
}