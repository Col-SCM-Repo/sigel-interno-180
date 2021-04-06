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
        //dd($aux);
        foreach ($aux as $parentesco ) {
            $apoderado = [
                'parentesco_id' => $parentesco->id(),
                'tipo' => $parentesco->TipoParentesco->nombre(),
                'nombres' => $parentesco->Apoderado->nombres(),
                'apellidos' => $parentesco->Apoderado->apellidos(),
            ];
            array_push($apoderados, $apoderado);
        }
        return response()->json($apoderados);
    }
}
