<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa las categorías de ingresos y gastos.
 */
class Categoria extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'categorias';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_categoria';

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
        'icono',
        'color_hex',
    ];

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las transacciones de la categoría.
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'id_categoria', 'id_categoria');
    }

    /**
     * Relación con el detalle de presupuestos.
     */
    public function detallesPresupuesto()
    {
        return $this->hasMany(PresupuestoDetalleCategoria::class, 'id_categoria', 'id_categoria');
    }
}