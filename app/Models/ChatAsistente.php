<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una conversación con el asistente financiero.
 */
class ChatAsistente extends Model
{
    use HasFactory;

    /**
     * Tabla asociada en la base de datos.
     */
    protected $table = 'chat_asistente';

    /**
     * Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_chat';

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
        'titulo_chat',
        'fecha_creacion',
    ];

    /**
     * Conversión automática de tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
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
     * Relación con los mensajes del chat.
     */
    public function mensajes()
    {
        return $this->hasMany(MensajeAsistente::class, 'id_chat', 'id_chat');
    }
}