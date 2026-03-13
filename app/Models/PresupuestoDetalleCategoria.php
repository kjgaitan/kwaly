<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa el detalle de gasto por categoría en un presupuesto.
 */
class PresupuestoDetalleCategoria extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'presupuesto_detalle_categoria';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_detalle';

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
        'id_presupuesto',
        'id_categoria',
        'limite_monto',
        'monto_gastado',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'limite_monto' => 'decimal:2',
            'monto_gastado' => 'decimal:2',
        ];
    }

    /**
     * Relación con el presupuesto mensual.
     */
    public function presupuesto()
    {
        return $this->belongsTo(PresupuestoMensual::class, 'id_presupuesto', 'id_presupuesto');
    }

    /**
     * Relación con la categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}