<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Override;

class UpdateTramiteRequest extends FormRequest
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
        $tramite = $this->route('tramite');
        $tramiteId = $tramite instanceof \App\Models\Tramite ? $tramite->id : $tramite;
        return [
            'codigo' => 'sometimes|required|string|max:50|unique:tramites,codigo,' . $tramiteId,
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'institucion_id' => 'sometimes|required|exists:instituciones,id',
            'dias_habiles' => 'sometimes|required|integer|min:1',
            'activo' => 'sometimes|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
