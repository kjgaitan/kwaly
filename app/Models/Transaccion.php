<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa los movimientos financieros del sistema.
 */
class Transaccion extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'transacciones';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_transaccion';

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
        'id_cuenta',
        'id_categoria',
        'tipo_movimiento',
        'titulo',
        'descripcion',
        'monto',
        'fecha_transaccion',
        'metodo_pago',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_transaccion' => 'datetime',
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
     * Relación con la cuenta financiera.
     */
    public function cuenta()
    {
        return $this->belongsTo(CuentaFinanciera::class, 'id_cuenta', 'id_cuenta');
    }

    /**
     * Relación con la categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}