<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreTramiteRequest extends FormRequest
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
            'codigo' => 'required|string|max:50|unique:tramites,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'institucion_id' => 'required|exists:instituciones,id',
            'dias_habiles' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'El código del trámite ya está en uso.',
            'institucion_id.exists' => 'La institución asociada al trámite no existe.',
            'dias_habiles.min' => 'Los días hábiles deben ser al menos 1.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
