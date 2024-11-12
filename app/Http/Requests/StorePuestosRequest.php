<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePuestosRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'nompuesto' => 'required|string|max:100|unique:puestos,nompuesto',
            'sigla' => 'required|string|max:10|unique:puestos,sigla',
            'idorg' => 'required|exists:organizacion,idorg',
        ];
    }
    public function messages()
    {
        return [
            'nompuesto.required' => 'El nombre del puesto es obligatorio.',
            'nompuesto.string' => 'El nombre del puesto debe ser un texto.',
            'nompuesto.max' => 'El nombre del puesto no debe superar los 100 caracteres.',
            'nompuesto.unique' => 'El nombre del puesto ya existe.',

            'sigla.required' => 'La sigla es obligatoria.',
            'sigla.string' => 'La sigla debe ser un texto.',
            'sigla.max' => 'La sigla no debe superar los 10 caracteres.',
            'sigla.unique' => 'La sigla ya existe.',

            'idorg.required' => 'El ID de la organización es obligatorio.',
            'idorg.exists' => 'La organización seleccionada no existe.',
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
