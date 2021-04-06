<?php

namespace App\Http\Controllers;

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
                'parentesco_id' => $parentesco->id(),
                'tipo' => $parentesco->TipoParentesco->nombre(),
                'tipo_id' => $parentesco->TipoParentesco->nombre(),
                'nombres' => $parentesco->Apoderado->nombres(),
                'apellidos' => $parentesco->Apoderado->apellidos(),
                'direccion' => $parentesco->Apoderado->direccion(),
                'telefono' => $parentesco->Apoderado->telefono(),
                'celular' => $parentesco->Apoderado->celular(),
                'correo' => $parentesco->Apoderado->correo(),
                'fecha_nacimiento' => $parentesco->Apoderado->fecha_nacimineto(),
                'genero' => $parentesco->Apoderado->genero(),
                'vive' => $parentesco->Apoderado->vive(),
            ];
            array_push($apoderados, $apoderado);
        }
        return response()->json($apoderados);
    }
}
