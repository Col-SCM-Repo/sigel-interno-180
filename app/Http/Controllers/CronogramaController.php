<?php

namespace App\Http\Controllers;

use App\CronogramaPago;
use App\Matricula;
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    public function Index($matricula_id)
    {
        return view('cronograma.index')->with('matricula_id', $matricula_id);
    }

    public function ObtenerCronogramasPorMatriculaID(Request $request)
    {
        $cronogramas = [];
        $matricula = Matricula::find($request->matricula_id);
        foreach ($matricula->CronogramaPagos as $cronograma_aux) {
            $cronograma =[
                'cronograma_id'=>$cronograma_aux->id(),
                'concepto'=>$cronograma_aux->concepto(),
                'mes'=>$cronograma_aux->ConceptoPago->Concepto->concepto(),
                'monto'=>$cronograma_aux->monto(),
                'estado'=>$cronograma_aux->estado(),
            ];
            array_push($cronogramas, $cronograma);
        }
        $data=[
            'cronogramas'=>$cronogramas,
            'alumno'=> $matricula->Alumno->apellidos(). ', '.$matricula->Alumno->nombres(),
        ];
        return response()->json($data);
    }
}
