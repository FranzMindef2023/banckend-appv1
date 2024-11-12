<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePersonasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:100',
            'appaterno' => 'nullable|string|max:50',
            'apmaterno' => 'nullable|string|max:50',
            'ci' => 'required|string|max:20|unique:personas,ci',
            'complemento' => 'nullable|string|max:10',
            'codper' => 'required|string|max:20|unique:personas,codper',
            'email' => 'nullable|email|max:100|unique:personas,email',
            'celular' => 'nullable|string|max:15',
            'fechanacimiento' => 'required|date',
            'gsanguineo' => 'nullable|string|max:3',
            'idfuerza' => 'required|exists:fuerza,idfuerza',
            'idespecialidad' => 'required|exists:especialidades,idespecialidad',
            'idgrado' => 'required|exists:grados,idgrado',
            'idsexo' => 'required|exists:sexos,idsexo',
            'idarma' => 'required|exists:armas,idarma',
            'status' => 'required|boolean'
        ];
    }
    public function messages()
    {
        return [
            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.string' => 'El nombre debe ser una cadena de texto.',
            'nombres.max' => 'El nombre no debe superar los 100 caracteres.',

            'appaterno.string' => 'El apellido paterno debe ser una cadena de texto.',
            'appaterno.max' => 'El apellido paterno no debe superar los 50 caracteres.',

            'apmaterno.string' => 'El apellido materno debe ser una cadena de texto.',
            'apmaterno.max' => 'El apellido materno no debe superar los 50 caracteres.',

            'ci.required' => 'La cédula de identidad es obligatoria.',
            'ci.string' => 'La cédula de identidad debe ser una cadena de texto.',
            'ci.max' => 'La cédula de identidad no debe superar los 20 caracteres.',
            'ci.unique' => 'La cédula de identidad ya está registrada.',

            'complemento.string' => 'El complemento debe ser una cadena de texto.',
            'complemento.max' => 'El complemento no debe superar los 10 caracteres.',

            'codper.required' => 'El código de persona es obligatorio.',
            'codper.string' => 'El código de persona debe ser una cadena de texto.',
            'codper.max' => 'El código de persona no debe superar los 20 caracteres.',
            'codper.unique' => 'El código de persona ya está registrado.',

            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo electrónico no debe superar los 100 caracteres.',
            'email.unique' => 'El correo electrónico ya está registrado.',

            'celular.string' => 'El número de celular debe ser una cadena de texto.',
            'celular.max' => 'El número de celular no debe superar los 15 caracteres.',

            'fechanacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechanacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',

            'gsanguineo.string' => 'El grupo sanguíneo debe ser una cadena de texto.',
            'gsanguineo.max' => 'El grupo sanguíneo no debe superar los 3 caracteres.',

            'idfuerza.required' => 'El ID de la fuerza es obligatorio.',
            'idfuerza.exists' => 'La fuerza seleccionada no existe.',

            'idespecialidad.required' => 'El ID de la especialidad es obligatorio.',
            'idespecialidad.exists' => 'La especialidad seleccionada no existe.',

            'idgrado.required' => 'El ID del grado es obligatorio.',
            'idgrado.exists' => 'El grado seleccionado no existe.',

            'idsexo.required' => 'El ID del sexo es obligatorio.',
            'idsexo.exists' => 'El sexo seleccionado no existe.',

            'idarma.required' => 'El ID del arma es obligatorio.',
            'idarma.exists' => 'El arma seleccionada no existe.',

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
