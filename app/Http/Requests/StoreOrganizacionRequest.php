<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrganizacionRequest extends FormRequest
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
        $id = $this->route('organizacion');
        return [
            'nomorg' => 'required|string|max:100',
            'sigla' => 'required|string|max:30|unique:organizacion,sigla,' . $id . ',idorg',
            'idpadre' => 'nullable|integer|exists:organizacion,idorg',
        ];
    }
    public function messages()
    {
        return [
            'nomorg.required' => 'El nombre de la organización es obligatorio.',
            'nomorg.string' => 'El nombre de la organización debe ser un texto.',
            'nomorg.max' => 'El nombre de la organización no debe superar los 100 caracteres.',

            'sigla.required' => 'La sigla es obligatoria.',
            'sigla.string' => 'La sigla debe ser un texto.',
            'sigla.max' => 'La sigla no debe superar los 30 caracteres.',
            'sigla.unique' => 'La sigla ya existe.',

            'idpadre.exists' => 'La organización superior seleccionada no existe.',
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
