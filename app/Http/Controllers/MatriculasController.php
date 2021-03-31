<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Matricula;
use Illuminate\Http\Request;

class MatriculasController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
       $this->ordenarArray = $ordenarArray;
    }
    public function ObtenerMatriculasPorAlumno(Request $request)
    {
        $matriculas=[];
        $matriculas_aux = Matricula::where('MP_ALU_ID',$request->alumno_id)->get();
        foreach ($matriculas_aux as $matricula_aux) {
            $matricula =[
                'matricula_id'=>$matricula_aux->id(),
                'anio'=>$matricula_aux->Vacante->AnioAcademico->nombre(),
                'nivel'=>$matricula_aux->Vacante->Nivel->nivel(),
                'grado'=>$matricula_aux->Vacante->Grado->grado(),
                'seccion'=>$matricula_aux->Vacante->Seccion->seccion(),
                'estado'=>$matricula_aux->estado(),
            ];
            array_push($matriculas, $matricula);
        }
        return response()->json($this->ordenarArray->Descendete($matriculas,'anio'));
    }
}
