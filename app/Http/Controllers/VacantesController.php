<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\Helpers\OrdenarArray;
use App\Vacante;
use Illuminate\Http\Request;

class VacantesController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        return $this->ordenarArray = $ordenarArray;
    }
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

    public function VistaReportePorAnioNivel()
    {
        return view('aulas.cant_alumnos_nivel');
    }
    public function ObtenerSeccionesPorAnionivel(Request $request)
    {
        $secciones = [];
        $aux = Vacante::where('MP_ANIO_ID', $request->anio_id)
                        ->where('MP_NIV_ID', $request->nivel_id)
                        ->orderBy('MP_GRAD_ID')->orderBy('MP_SEC_ID')->get();
        foreach ($aux as $vacante) {
            $seccion = [
                'grado'=> $vacante->Grado->grado(),
                'seccion'=> $vacante->Seccion->seccion(),
                'total_vacantes'=> $vacante->total_vacantes(),
                'vacantes_ocupadas'=> $vacante->vacantes_ocupadas(),
                'vacantes_disponibles'=> $vacante->vacantes_disponibles(),
            ];
            array_push($secciones,$seccion);
        }
        return response()->json($secciones);
    }
}
