<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApoderado extends FormRequest
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
        return [
            'familiar.tipo_documento_id' => 'required',
            'familiar.dni' => 'required|numeric',
            'familiar.nombres' => 'required',
            'familiar.apellidos' => 'required',
            'familiar.genero' => 'required',
            'familiar.fecha_nacimiento' => 'required',
            'familiar.celular' => 'required',
            'familiar.religion_id' => 'required',
            'familiar.estado_civil_id' => 'required',
            'familiar.tipo_parentesco_id' => 'required',
            'familiar.pais_nacimiento_id' => 'required',
            'familiar.distrito_nacimiento_id' => 'required',
            'familiar.pais_residencia_id' => 'required',
            'familiar.distrito_residencia_id' => 'required',
            'familiar.grado_instruccion_id' => 'required',
            'familiar.centro_laboral_id' => 'required',
            'familiar.ocupacion_id' => 'required',
            'familiar.direccion' => 'required'

        ];
    }
    public function messages()
    {
        return[
            'alumno.tipo_documento_id.required' => 'Este campo es obligatorio.',
            'familiar.tipo_documento_id.required' => 'Este campo es obligatorio.',
            'familiar.dni.required' => 'Este campo es obligatorio.',
            'familiar.dni.numeric' => 'Este campo debe contener solo números.',
            'familiar.nombres.required' => 'Este campo es obligatorio.',
            'familiar.apellidos.required' => 'Este campo es obligatorio.',
            'familiar.genero.required' => 'Este campo es obligatorio.',
            'familiar.fecha_nacimiento.required' => 'Este campo es obligatorio.',
            'familiar.celular.required' => 'Este campo es obligatorio.',
            'familiar.religion_id.required' => 'Este campo es obligatorio.',
            'familiar.estado_civil_id.required' => 'Este campo es obligatorio.',
            'familiar.tipo_parentesco_id.required' => 'Este campo es obligatorio.',
            'familiar.pais_nacimiento_id.required' => 'Este campo es obligatorio.',
            'familiar.distrito_nacimiento_id.required' => 'Este campo es obligatorio.',
            'familiar.pais_residencia_id.required' => 'Este campo es obligatorio.',
            'familiar.distrito_residencia_id.required' => 'Este campo es obligatorio.',
            'familiar.grado_instruccion_id.required' => 'Este campo es obligatorio.',
            'familiar.centro_laboral_id.required' => 'Este campo es obligatorio.',
            'familiar.ocupacion_id.required' => 'Este campo es obligatorio.',
            'familiar.direccion.required' => 'Este campo es obligatorio.'
        ];
    }
}
