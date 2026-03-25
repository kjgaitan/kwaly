<?php

namespace App\Http\Requests\Calendario;

use Illuminate\Foundation\Http\FormRequest;

class CalendarioIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mes' => ['nullable', 'regex:/^\d{4}-\d{2}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'mes.regex' => 'El formato del mes debe ser YYYY-MM.',
        ];
    }
}