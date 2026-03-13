<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un mensaje dentro del chat del asistente.
 */
class MensajeAsistente extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'mensajes_asistente';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_mensaje';

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
        'id_chat',
        'emisor',
        'mensaje',
        'fecha_envio',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_envio' => 'datetime',
        ];
    }

    /**
     * Relación con el chat del asistente.
     */
    public function chat()
    {
        return $this->belongsTo(ChatAsistente::class, 'id_chat', 'id_chat');
    }
}