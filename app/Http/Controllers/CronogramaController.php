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
        $matricula = Matricula::find($request->matricula_id);
        foreach ($matricula->CronogramaPagos as $cronograma_aux) {
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
        $data=[
            'cronogramas'=>$cronogramas,
            'alumno'=> $matricula->Alumno->apellidos(). ', '.$matricula->Alumno->nombres(),
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
