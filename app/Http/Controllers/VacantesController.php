<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\Vacante;
use Illuminate\Http\Request;

class VacantesController extends Controller
{

    public function ObtenerPorNivelGradoDelAnioActual(Request $request)
    {
        $secciones = [];
        $anio = AnioAcademico::where('MP_ANIO_ESTADO', 'VIGENTE')->first();
        $vacantes = Vacante::where('MP_NIV_ID',$request->nivel_id)->where('MP_GRAD_ID',$request->grado_id)->where('MP_ANIO_ID',$anio->id())->get();
        foreach ($vacantes as $vacante ) {
            $seccion = [
                'vacante_id'=> $vacante->id(),
                'grado'=>$vacante->Grado->grado(),
                'seccion'=>$vacante->Seccion->seccion(),
                'nivel'=>$vacante->Nivel->nivel()
            ];
            array_push($secciones,$seccion);
        }
        return response()->json($secciones);
    }
}
