<?php

namespace App\Http\Requests\Compartido;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMiembroGrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_grupo' => ['required', 'integer', 'exists:grupos_compartidos,id_grupo'],
            'email' => ['required', 'email'],
            'rol' => ['required', 'in:admin,miembro'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_grupo.required' => 'El grupo es obligatorio.',
            'id_grupo.integer' => 'El identificador del grupo no es válido.',
            'id_grupo.exists' => 'El grupo seleccionado no existe.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes introducir un correo electrónico válido.',

            'rol.required' => 'Debes seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_grupo' => 'grupo',
            'email' => 'correo electrónico',
            'rol' => 'rol',
        ];
    }
}