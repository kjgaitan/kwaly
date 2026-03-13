<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa los presupuestos mensuales del usuario.
 */
class PresupuestoMensual extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'presupuestos_mensuales';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_presupuesto';

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
        'anio',
        'mes',
        'ingreso_estimado',
        'porcentaje_necesidades',
        'porcentaje_deseos',
        'porcentaje_ahorro',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ingreso_estimado' => 'decimal:2',
            'porcentaje_necesidades' => 'decimal:2',
            'porcentaje_deseos' => 'decimal:2',
            'porcentaje_ahorro' => 'decimal:2',
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
     * Relación con el detalle del presupuesto.
     */
    public function detalles()
    {
        return $this->hasMany(PresupuestoDetalleCategoria::class, 'id_presupuesto', 'id_presupuesto');
    }
}