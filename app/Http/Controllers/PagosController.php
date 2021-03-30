<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\CronogramaPago;
use App\Helpers\NumeroATexto;
use App\Helpers\OrdenarArray;
use App\Pago;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class PagosController extends Controller
{
    private $numeroATexto;
    public function __construct( NumeroATexto $numeroATexto)
    {
        $this->numeroATexto=$numeroATexto;
    }
    public function ObtenerPagosPorCronogramaId(Request $request)
    {
        $pagos=[];
        $pagos_aux= Pago::where('MP_CRO_ID',$request->cronograma_id)->get();
        foreach ($pagos_aux as $pago_aux ) {
            $pago=[
                'pago_id'=>$pago_aux->id(),
                'numero'=>$pago_aux->serie().' - '.$pago_aux->numero(),
                'tipo'=>$pago_aux->TipoComprobante->tipo(),
                'monto'=>$pago_aux->monto(),
                'fecha'=>$pago_aux->fecha(),
                'usuario'=>$pago_aux->Usuario->apellidos().', '.$pago_aux->Usuario->nombres(),
            ];
            array_push($pagos, $pago);
        }
        return response()->json($pagos);
    }
    public function GuardarPago(Request $request)
    {
        try {
            $serie =Auth::user()->SerieComprobante()->get()->last();
            $num_serie = Pago::where('MP_PAGO_SERIE', $serie->serie())->max('MP_PAGO_NRO');
            $cronograma = CronogramaPago::find($request->cronograma_id);
            $estado_cronograma = '';
            if(number_format($request->monto,2)<number_format($request->saldo,2)){
                $estado_cronograma='SALDO';
            }else if(number_format($request->monto,2)==number_format($request->saldo,2)){
                $estado_cronograma='CANCELADO';
            }
            //dd(DateTime::createFromFormat('d/m/Y H:i:s', $request->fecha)->format('Y-m-d\TH:i:s'));//elimnar esta linea pararegistrar pagos
            $pago = new Pago();
            $pago->MP_PAGO_FECHA = DateTime::createFromFormat('d/m/Y H:i:s', $request->fecha)->format('Y-m-d\TH:i:s');
            $pago->MP_PAGO_NRO = $num_serie+1;
            $pago->MP_PAGO_OBS = $request->observacion;
            $pago->MP_SERCOM_ID = $serie->id();
            $pago->MP_TIPCOM_ID = 8; //TIPO DE BOLETA ELECTRONICA
            $pago->USU_ID = Auth::user()->id();
            $pago->MP_CRO_ID = $cronograma->id();
            $pago->MP_PAGO_MONTO = $request->monto;
            $pago->MP_PAGO_SERIE = $serie->serie();
            $pago->MP_MAT_ID = $cronograma->matriculaId();
            $pago->MP_PAGO_LEE_MONTO= $this->numeroATexto->Soles($request->monto);
            $pago->save();
            $cronograma->MP_CRO_ESTADO = $estado_cronograma;
            $cronograma->save();
            return $pago->id();
        } catch (\Throwable $th) {
            return $th;
        }

    }
}
