<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConsultaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        if ($this->isMethod('post')) {
            return [
                'id' => 'required|integer|exists:registro_dte,id', 
                'dte' => 'required|array', 
            ];
        }

        if ($this->isMethod('get')) {
            return [
                // in:01,03,04,05,06,07,08,09,11,14,15
                'tipoDocumento' => 'nullable|string|exists:mh_tipo_documento,codigo',
                'fechaInicio' => 'nullable|date_format:Y-m-d',
                'fechaFin' => 'nullable|date_format:Y-m-d',
                'estado' => 'nullable|integer|in:0,1',
            ];
        }

        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
