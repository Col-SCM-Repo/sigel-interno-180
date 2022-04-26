<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnos extends FormRequest
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
                'alumno.nombres' => 'required',
                'alumno.apellidos' => 'required',
                'alumno.dni' => 'required|numeric',
                'alumno.genero' => 'required',
                'alumno.correo' => 'required',
                'alumno.fecha_nacimiento'=>'required',
                'alumno.religion_id'=>'required',
                'alumno.pais_id'=>'required',
                'alumno.distrito_nacimiento'=>'required',
                'alumno.distrito_residencia'=>'required',
                'alumno.direccion'=>'required'
            ];
        }
    }
    public function messages()
    {
        return[
            'alumno.nombres.required' => 'Este campo es obligatorio',
            'alumno.apellidos.required' => 'Este campo es obligatorio',
            'alumno.dni.required' => 'Este campo es obligatorio',
            'alumno.dni.numeric' => 'Este campo solo debe contener números',
            'alumno.genero.required' => 'Este campo es obligatorio',
            'alumno.correo.required' => 'Este campo es obligatorio',
            'alumno.fecha_nacimiento.required'=>'El campo fecha de nacimiento es obligatorio',
            'alumno.religion_id.required'=>'El campo religión es obligatorio',
            'alumno.pais_id.required'=>'El campo país es obligatorio',
            'alumno.distrito_nacimiento.required'=>'El campo distrito de nacimiento es obligatorio',
            'alumno.distrito_residencia.required'=>'El campo distrito de residencia es obligatorio',
            'alumno.direccion.required'=>'Este campo es obligatorio'
        ];
    }
}
