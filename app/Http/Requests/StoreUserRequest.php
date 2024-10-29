<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir la validación
    }

    public function rules()
    {
        
        return [
            'ci' => 'required|string|unique:users,ci',
            'nombres' => 'required|string|min:3|max:255',
            'appaterno' => 'nullable|string|min:3|max:255',
            'apmaterno' => 'nullable|string|min:3|max:255',
            'email' => 'nullable|email|unique:users,email',
            'celular' => 'required|digits_between:8,15',
            'usuario' => 'required|string|min:3|max:255|unique:users,usuario',
            'password' => 'required|min:8',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Este CI ya está en uso.',
            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.min' => 'El nombre debe tener al menos 3 caracteres.',
            'appaterno.min' => 'El apellido paterno debe tener al menos 3 caracteres.',
            'apmaterno.min' => 'El apellido materno debe tener al menos 3 caracteres.',
            'email.email' => 'El correo debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo ya está en uso.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.digits_between' => 'El número de celular debe tener entre 8 y 15 dígitos.',
            'usuario.required' => 'El nombre de usuario es obligatorio.',
            'usuario.unique' => 'Este nombre de usuario ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Datos de entrada no válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
