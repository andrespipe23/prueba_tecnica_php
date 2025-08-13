<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'Se requiere un nombre para el registro.',
            'name.max'                => 'El nombre es demasiado largo, son 100 caracteres permitidos.',
            'email.required'          => 'Se requiere el email para el registro.',
            'email.email'             => 'El formato de email es invalido.',
            'email.max'               => 'El email es demasiado largo.',
            'email.unique'            => 'El email ya esta registrado en el sistema.',
            'password.required'       => 'La contraseña es requerida.',
            'password.min'            => 'La contraseña debe contener como minimo ocho caracteres.',
            'password.regex'          => 'La contraseña debe contener al menos una letra y un número, y solo puede incluir letras y números.',
            'password.confirmed'      => 'La contraseña debe coincidir con la de verificación.'
        ];
    }
}
