<?php

namespace App\Http\Controllers;

use App\CronogramaPago;
use App\Matricula;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class CronogramaController extends Controller
{
    public function Index($matricula_id)
    {
        return view('cronograma.index')->with('matricula_id', $matricula_id);
    }

    public function ObtenerCronogramasPorMatriculaID(Request $request)
    {
        $cronogramas = [];
        $matricula_aux = Matricula::find($request->matricula_id);
        foreach ($matricula_aux->CronogramaPagos as $cronograma_aux) {
            $cronograma =[
                'cronograma_id'=>$cronograma_aux->id(),
                'concepto'=>$cronograma_aux->concepto(),
                'mes'=>$cronograma_aux->ConceptoPago->Concepto->concepto(),
                'monto'=>$cronograma_aux->monto(),
                'estado'=>$cronograma_aux->estado(),
                'fecha_vencimiento'=>date('d-m-Y', strtotime($cronograma_aux->fechaVencimiento())),
                'vencido'=>strtotime($cronograma_aux->fechaVencimiento())<=strtotime(date('d-m-Y'))?true:false,
            ];
            array_push($cronogramas, $cronograma);
        }
        $matricula = [
            'id'=>$matricula_aux->id(),
            'nivel'=>$matricula_aux->Vacante->Nivel->nivel(),
            'seccion'=>$matricula_aux->Vacante->seccion->seccion(),
            'grado'=>$matricula_aux->Vacante->Grado->grado(),
            'anio'=>$matricula_aux->Vacante->AnioAcademico->nombre(),
        ];
        $data=[
            'cronogramas'=>$cronogramas,
            'alumno'=> $matricula_aux->Alumno->apellidos(). ', '.$matricula_aux->Alumno->nombres(),
            'matricula'=>$matricula
        ];
        return response()->json($data);
    }
    public function ObtenerSaldoDeCronograma(Request $request)
    {

        $cronograma = CronogramaPago::find($request->cronograma_id);
        $saldo = $cronograma->monto();
        foreach ($cronograma->Pagos as $pago) {
            $saldo -= $pago->monto();
        }
        $data=[
            'saldo'=>$saldo,
            'fecha_pago'=>date('d/m/Y H:i:s'),
        ];
        return response()->json($data);
    }
}
