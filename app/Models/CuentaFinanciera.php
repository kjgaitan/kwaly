<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa las cuentas financieras del usuario.
 */
class CuentaFinanciera extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'cuentas_financieras';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_cuenta';

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
        'nombre',
        'tipo_cuenta',
        'saldo_actual',
        'moneda',
    ];

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las transacciones de la cuenta.
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'id_cuenta', 'id_cuenta');
    }
}