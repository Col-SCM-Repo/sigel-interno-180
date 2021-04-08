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

    public function NuevaVista($alumno_id,$matricula_id)
    {
       return view('matriculas.nueva')->with('alumno_id', $alumno_id)->with('matricula_id', $matricula_id);
    }
    public function ModeloMatricula($matricula_id)
    {
        if ($matricula_id ==0) {
            $matricula =[
                'id' => 0,
                'pariente_id' => '',
                'alumno_id' => 0,
                'tipo_id' => 1,
                'observacion' => '',
                'ie_procedencia_id' => '',
                'estado' => 2,
                'vacante_id' => '',
                'nivel' => '',
                'grado' => '',
                'monto_matricula' => '',
                'monto_pension' => '',
                'fecha' => date('Y-m-d\TH:i:s')
            ];
        }else{
            $aux = Matricula::find($matricula_id);
            $matricula =[
                'id' => $aux->id(),
                'pariente_id' => $aux->pariente_id(),
                'alumno_id' => $aux->alumno_id(),
                'tipo_id' => $aux->tipo_id(),
                'observacion' => $aux->observacion(),
                'ie_procedencia_id' => $aux->ie_procedencia_id(),
                'estado' => self::obtenerEstadoNum($aux->estado()),
                'vacante_id' =>  $aux->vacante_id(),
                'nivel' => $aux->Vacante->Nivel->id(),
                'grado' => $aux->Vacante->Grado->id(),
                'monto_matricula' => '',
                'monto_pension' => '',
                'fecha' => date('Y-m-d\TH:i:s',strtotime($aux->fecha()))
            ];
        }

        return $matricula;
    }
    private function obtenerEstadoNum($estado)
    {
        $estado_num=2;
        switch ($estado) {
            case "NUEVO":
                $estado_num = 1;
                break;
            case "NORMAL":
                $estado_num = 2;
                break;
            case "PRIMERA MATRICULA":
                $estado_num = 3;
                break;
            case "RETIRADO":
                $estado_num = 4;
                break;
            case "ABANDONO":
                $estado_num = 5;
                break;
            default:
                # code...
                break;
        }
        return $estado_num;
    }
}
