<?php

namespace App\Http\Requests\Compartido;

use Illuminate\Foundation\Http\FormRequest;

class StoreMiembroGrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_grupo' => ['required', 'integer', 'exists:grupos_compartidos,id_grupo'],
            'id_usuario' => ['required', 'integer', 'exists:usuarios,id_usuario'],
            'rol' => ['required', 'in:admin,miembro'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_grupo.required' => 'El grupo es obligatorio.',
            'id_grupo.exists' => 'El grupo seleccionado no existe.',
            'id_usuario.required' => 'Selecciona un usuario valido para anadirlo al grupo.',
            'id_usuario.exists' => 'Selecciona un usuario valido para anadirlo al grupo.',
            'rol.required' => 'Debes seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es valido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_grupo' => 'grupo',
            'id_usuario' => 'usuario',
            'rol' => 'rol',
        ];
    }
}
