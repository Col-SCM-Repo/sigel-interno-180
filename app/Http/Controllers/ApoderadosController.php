<?php

namespace App\Http\Controllers;

use App\Apoderado;
use App\Parentesco;
use Illuminate\Http\Request;

class ApoderadosController extends Controller
{
    public function ObtenerPorAlumno(Request $request)
    {
        $apoderados =[];
        $aux = Parentesco::where('MP_ALU_ID',$request->alumno_id)->get();
        foreach ($aux as $parentesco ) {
            $apoderado = [
                'apoderado_id' => $parentesco->Apoderado->id(),
                'parentesco_id' => $parentesco->id(),
                'tipo' => $parentesco->TipoParentesco->nombre(),
                'tipo_id' => $parentesco->tipo_id(),
                'nombres' => $parentesco->Apoderado->nombres(),
                'apellidos' => $parentesco->Apoderado->apellidos(),
                'dni' => $parentesco->Apoderado->dni(),
                'direccion' => $parentesco->Apoderado->direccion(),
                'telefono' => $parentesco->Apoderado->telefono(),
                'celular' => $parentesco->Apoderado->celular(),
                'correo' => $parentesco->Apoderado->correo(),
                'fecha_nacimiento' => date('Y-m-d',strtotime($parentesco->Apoderado->fecha_nacimineto())),
                'genero' => $parentesco->Apoderado->genero(),
                'vive' => $parentesco->Apoderado->vive(),
                'estado_civil_id' => $parentesco->Apoderado->estado_civil_id(),
                'religion_id' => $parentesco->Apoderado->religion_id(),
                'pais_residencia_id' => $parentesco->Apoderado->pais_residencia_id(),
                'distrito_residencia_id' => $parentesco->Apoderado->distrito_residencia_id(),
                'pais_nacimiento_id' => $parentesco->Apoderado->pais_nacimiento_id(),
                'distrito_nacimiento_id' => $parentesco->Apoderado->distrito_nacimiento_id(),
                'centro_laboral_id' => $parentesco->Apoderado->centro_laboral_id(),
                'ocupacion_id' => $parentesco->Apoderado->ocupacion_id(),
                'grado_intruccion_id' => $parentesco->Apoderado->grado_intruccion_id(),
                'tipo_documento_id' => $parentesco->Apoderado->tipo_documento_id(),
            ];
            array_push($apoderados, $apoderado);
        }
        return response()->json($apoderados);
    }
    public function ModeloApoderado()
    {
        $apoderado = [
            'apoderado_id' => 0,
            'parentesco_id' => '',
            'tipo' => '',
            'tipo_id' => '',
            'nombres' => '',
            'apellidos' => '',
            'dni' => '',
            'direccion' => '',
            'telefono' =>'',
            'celular' => '',
            'correo' =>'',
            'fecha_nacimiento' => date('Y-m-d'),
            'genero' => '',
            'vive' => 'SI',
            'estado_civil_id' =>'',
            'religion_id' => '',
            'pais_residencia_id' => '',
            'distrito_residencia_id' => '',
            'pais_nacimiento_id' => '',
            'distrito_nacimiento_id' => '',
            'centro_laboral_id' => '',
            'ocupacion_id' => '',
            'grado_intruccion_id' => '',
            'tipo_documento_id' => '',
        ];
        return $apoderado;
    }
    public function GuardarApoderado(Request $request)
    {
        try {
            $familiar = (object)$request->familiar;
            if ($familiar->apoderado_id==0) {
               $apoderado = new Apoderado();
               $parentesco = new Parentesco();
            } else {
                $apoderado = Apoderado::find($familiar->apoderado_id);
                $parentesco = Parentesco::find($familiar->parentesco_id);
            }
            //dd($apoderado);
            $apoderado->MP_APO_NOMBRES =mb_strtoupper($familiar->nombres);
            $apoderado->MP_APO_APELLIDOS =mb_strtoupper($familiar->apellidos);
            $apoderado->MP_APO_NRODOC =$familiar->dni;
            $apoderado->MP_APO_DIRECCION =mb_strtoupper($familiar->direccion);
            $apoderado->MP_APO_CELULAR =$familiar->celular;
            $apoderado->MP_APO_EMAIL =$familiar->correo;
            $apoderado->MP_APO_FECHANAC =date('Y-m-d',strtotime($familiar->fecha_nacimiento));
            $apoderado->MP_APO_SEXO =$familiar->genero;
            $apoderado->MP_APO_VIVE =$familiar->vive;
            $apoderado->MP_EC_ID =$familiar->estado_civil_id;
            $apoderado->MP_REL_ID =$familiar->religion_id;
            $apoderado->MP_PAIS_ID =$familiar->pais_nacimiento_id;
            $apoderado->MP_PAIS_DIR_ID =$familiar->pais_residencia_id;
            $apoderado->MP_APO_UBIGDIR =$familiar->distrito_residencia_id;
            $apoderado->MP_APO_UBIGNAC =$familiar->distrito_nacimiento_id;
            $apoderado->MP_CL_ID =$familiar->centro_laboral_id;
            $apoderado->MP_OCU_ID =$familiar->ocupacion_id;
            $apoderado->MP_GI_ID =$familiar->grado_intruccion_id;
            $apoderado->MP_TIPDOC_ID =$familiar->tipo_documento_id;
            $apoderado->MP_APO_TELEFONO =$familiar->telefono;
            $apoderado->save();

            $parentesco->MP_ALU_ID = $request->alumno_id;
            $parentesco->MP_APO_ID = $apoderado->id();
            $parentesco->MP_TIPAR_ID = $familiar->tipo_id;
            $parentesco->save();
        } catch (\Throwable $th) {
           return response()->json($th,401);
        }
    }
}
