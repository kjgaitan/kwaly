<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';

    public $timestamps = false;

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

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'monto_total' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}