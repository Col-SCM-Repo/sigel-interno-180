<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatriculas extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'matricula.pariente_id' => 'required',
                'matricula.institucion_educativa_procedencia_id' => 'required',
                'matricula.tipo_matricula_id' => 'required',
                'matricula.estado' => 'required',
                'matricula.vacante_id' => 'required',
            ];
        }
    }
    /**
     * Get the messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return[
            'matricula.pariente_id.required' => 'Este campo es obligatorio',
            'matricula.institucion_educativa_procedencia_id.required' => 'Este campo es obligatorio',
            'matricula.tipo_matricula_id.required' => 'Este campo es obligatorio',
            'matricula.estado.required' => 'Este campo es obligatorio',
            'matricula.vacante_id.required' => 'Este campo es obligatorio',
        ];
    }
}
