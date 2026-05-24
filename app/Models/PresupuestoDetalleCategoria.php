<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PresupuestoMensual;
use App\Models\Categoria;
use App\Models\Transaccion;

class PresupuestoDetalleCategoria extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_detalle_categoria';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

   protected $fillable = [
    'id_presupuesto',
    'id_categoria',
    'tipo_presupuesto',
    'limite_monto',
    'monto_gastado'
    ];

    protected function casts(): array
    {
        return [
            'limite_monto' => 'decimal:2',
            'monto_gastado' => 'decimal:2',
        ];
    }

    public function presupuesto()
    {
        return $this->belongsTo(PresupuestoMensual::class, 'id_presupuesto', 'id_presupuesto');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function recalcularMontoGastado(): void
    {
        $presupuesto = $this->presupuesto;

        if (!$presupuesto) {
            return;
        }

        $totalGastado = Transaccion::where('id_usuario', $presupuesto->id_usuario)
            ->where('id_categoria', $this->id_categoria)
            ->where('tipo_movimiento', 'gasto')
            ->whereYear('fecha_transaccion', $presupuesto->anio)
            ->whereMonth('fecha_transaccion', $presupuesto->mes)
            ->sum('monto');

        $this->update([
            'monto_gastado' => $totalGastado,
        ]);
    }
}