<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:200',
            'description' => 'required|max:1000',
            'due_date' => 'date|after_or_equal:today',
            'status' => 'required|in:pending,in_progress,completed',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                    => 'Se requiere un título para el registro.',
            'title.string'                      => 'El formato del título debe ser texto.',
            'title.max'                         => 'El título es demasiado largo, son 200 caracteres permitidos.',
            'description.required'              => 'Se requiere una descripción para el registro.',
            'description.max'                   => 'La descripción es demasiado larga, son 1000 caracteres permitidos.',
            'due_date.date'                     => 'El formato de la fecha de vencimiento es incorrecto.',
            'due_date.after_or_equal'           => 'La fecha de vencimiento no puede ser menor que la fecha actual.',
            'status.required'                   => 'Se requiere un estado para el registro.',
            'status.in'                         => 'El estado es invalido. Debe ser: pending, in_progress o completed.',
            'user_id.required'                  => 'Se requiere un usuario para el registro.',
            'user_id.integer'                   => 'El formato del usuario_id debe ser un numero.',
            'user_id.exists'                    => 'El usuario no existe en el sistema.'
        ];
    }
}
