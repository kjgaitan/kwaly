<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa las facturas y pagos del usuario.
 */
class Factura extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'facturas';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_factura';

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
        'proveedor',
        'concepto',
        'descripcion',
        'monto_total',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
        'frecuencia',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto_total' => 'decimal:2',
            'fecha_vencimiento' => 'date',
            'fecha_pago' => 'date',
        ];
    }

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}