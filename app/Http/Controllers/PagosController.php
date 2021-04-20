<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\CronogramaPago;
use App\Helpers\NumeroATexto;
use App\Helpers\OrdenarArray;
use App\Pago;
use App\Seccion;
use App\User;
use App\Vacante;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class PagosController extends Controller
{
    private $numeroATexto;
    private $ordenarArray;
    public function __construct( NumeroATexto $numeroATexto,
                                OrdenarArray $ordenarArray)
    {
        $this->numeroATexto=$numeroATexto;
        $this->ordenarArray=$ordenarArray;
    }
    public function ObtenerPagosPorCronogramaId(Request $request)
    {
        $pagos=[];
        $pagos_aux= Pago::where('MP_CRO_ID',$request->cronograma_id)->get();
        foreach ($pagos_aux as $pago_aux ) {
            $pago=[
                'pago_id'=>$pago_aux->id(),
                'serie'=>$pago_aux->serie(),
                'serie_id'=>$pago_aux->serie_id(),
                'numero'=>$pago_aux->numero(),
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
            //dd(date('Y-m-d\T00:00:00',strtotime($request->fecha)));
            $serie =Auth::user()->SerieComprobante()->get()->last();
            $num_serie = Pago::where('MP_PAGO_SERIE', $serie->serie())->max('MP_PAGO_NRO');
            if(isset($request->cronograma_id)){
                $cronograma = CronogramaPago::find($request->cronograma_id);
                $estado_cronograma = '';
                if(number_format($request->monto,2)<number_format($request->saldo,2)){
                    $estado_cronograma='SALDO';
                }else if(number_format($request->monto,2)==number_format($request->saldo,2)){
                    $estado_cronograma='CANCELADO';
                }
            }
            $pago = new Pago();
            $pago->MP_PAGO_FECHA = substr($request->serie,0,1)=='E'? date('Y-m-d\T00:00:00',strtotime($request->fecha)):date('Y-m-d\TH:i:s');
            $pago->MP_PAGO_NRO = substr($request->serie,0,1)=='E'?$request->numeracion:$num_serie+1;
            $pago->MP_PAGO_OBS = $request->observacion==null?'':$request->observacion;
            $pago->MP_SERCOM_ID = substr($request->serie,0,1)=='E'? NULL:$serie->id();
            $pago->MP_TIPCOM_ID = substr($request->serie,0,1)=='E'?4:8; //TIPO DE FACTURA / TIPO DE BOLETA ELECTRONICA
            $pago->USU_ID = Auth::user()->id();
            $pago->MP_CRO_ID = isset($request->cronograma_id)?$cronograma->id():null;
            $pago->MP_CONPAGO_ID = isset($request->concepto_pago_id)?$request->concepto_pago_id:null;
            $pago->MP_PAGO_MONTO = $request->monto;
            $pago->MP_PAGO_SERIE = substr($request->serie,0,1)=='E'? $request->serie:$serie->serie();
            $pago->MP_MAT_ID = isset($request->cronograma_id)?$cronograma->matriculaId():$request->matricula_id;
            $pago->MP_PAGO_LEE_MONTO= $this->numeroATexto->Soles($request->monto);
            $pago->save();
            if (isset($request->cronograma_id)) {
                $cronograma->MP_CRO_ESTADO = $estado_cronograma;
                $cronograma->save();
            }
            return $pago->id();
        } catch (\Throwable $th) {
            return response()->json($th,401);
        }
    }
    public function GuardarNotaCredito(Request $request)
    {
        try {
            $datos_pago = (object)$request->pago;
            $pago_aux = Pago::find($datos_pago->pago_id);
            if (isset($pago_aux->CronogramaPago)) {
                $monto_pagado=0;
                foreach ($pago_aux->CronogramaPago->Pagos as $p) {
                    $monto_pagado += $p->monto();
                }
                $cronograma = $pago_aux->CronogramaPago;
                $estado_cronograma = '';
                if(number_format(number_format($monto_pagado,2)-number_format($datos_pago->monto,2),2)==number_format(0,2)){
                    $estado_cronograma='PENDIENTE';
                }else if(number_format(number_format($monto_pagado,2)-number_format($datos_pago->monto,2),2)<number_format($cronograma->monto(),2)){
                    $estado_cronograma='SALDO';
                }
            }
            $pago = new Pago();
            $pago->MP_PAGO_FECHA = date('Y-m-d\TH:i:s');
            $pago->MP_PAGO_FECHAEMISION = date('Y-m-d\TH:i:s');
            $pago->MP_PAGO_NRO = $datos_pago->correlativo;
            $pago->MP_PAGO_OBS = $datos_pago->observacion;
            $pago->MP_SERCOM_ID = $datos_pago->serie_id;
            $pago->MP_TIPCOM_ID = 5; //TIPO DE NOTA DE CREDITO
            $pago->USU_ID = Auth::user()->id();
            $pago->MP_CRO_ID = isset($pago_aux->CronogramaPago)?$cronograma->id():null;
            $pago->MP_CONPAGO_ID = isset($pago_aux->ConceptoPago)?$pago_aux->ConceptoPago->id():null;
            $pago->MP_PAGO_MONTO = -$datos_pago->monto;
            $pago->MP_PAGO_SERIE = $datos_pago->serie;
            $pago->MP_MAT_ID = isset($pago_aux->CronogramaPago)?$cronograma->matriculaId():$pago_aux->matricula_id();
            $pago->MP_PAGO_LEE_MONTO= 'Cero y 00/100 Soles';
            $pago->save();
            if (isset($pago_aux->CronogramaPago)) {
                $cronograma->MP_CRO_ESTADO = $estado_cronograma;
                $cronograma->save();
            }
            return $pago->id();
        } catch (\Throwable $th) {
            return response()->json($th,401);
        }
    }
    public function PagosDelDiaVista()
    {
        return view('reportes.vistas.pagos_del_dia');
    }
    public function ObtenerPagosDelDia(Request $request)
    {
        $pagos =[];
        $pagos_aux = Pago::whereDate('MP_PAGO_FECHA', '=',$request->fecha)->where('USU_ID',Auth::user()->id())->get();
        foreach ($pagos_aux as $pago_aux ) {
            $pago=[
                'pago_id'=>$pago_aux->id(),
                'fecha'=>date('d/m/Y H:i:s',strtotime($pago_aux->fecha())),
                'numero'=>$pago_aux->serie().' - '. $pago_aux->numero(),
                'observacion'=>$pago_aux->observacion(),
                'monto'=>$pago_aux->monto(),
                'concepto'=>$pago_aux->ConceptoPago?$pago_aux->ConceptoPago->Concepto->concepto():$pago_aux->CronogramaPago->ConceptoPago->Concepto->concepto(),
                'alumno'=>$pago_aux->Matricula->Alumno->apellidos().', '.$pago_aux->Matricula->Alumno->nombres(),
            ];
            array_push($pagos,$pago);
        }
        return $pagos;
    }
    public function PagosPorOtrosConceptosPorMatriula(Request $request)
    {
        $pagos =[];
        $aux = Pago::where('MP_MAT_ID',$request->matricula_id)->where('MP_CONPAGO_ID','!=',null)->get();
        //dd($aux);
        foreach ($aux as $pago_aux) {
            $pago=[
                'pago_id'=>$pago_aux->id(),
                'serie'=>$pago_aux->serie(),
                'serie_id'=>$pago_aux->serie_id(),
                'numero'=>$pago_aux->numero(),
                'tipo'=>$pago_aux->TipoComprobante->tipo(),
                'monto'=>$pago_aux->monto(),
                'fecha'=>$pago_aux->fecha(),
                'usuario'=>$pago_aux->Usuario->apellidos().', '.$pago_aux->Usuario->nombres(),
                'concepto'=>$pago_aux->ConceptoPago->Concepto->concepto(),
            ];
            array_push($pagos, $pago);
        }
        return $pagos;
    }
    public function ObtenerAlumnosMorosos(Request $request)
    {
        //dd($request);
        $anio_id = $request->anio_id;
        $nivel_id = $request->nivel_id;
        $seccion_id = $request->seccion_id;
        $concepto_id = $request->concepto_id;
        $estado = $request->estado==0?'TODOS':($request->estado==1?'SALDO':($request->estado==2?'PENDIENTE':''));
        $alumnos = [];
        if ($seccion_id == 0) {
            $secciones = Vacante::where('MP_ANIO_ID', $anio_id)->where('MP_NIV_ID', $nivel_id)->get();
            foreach ($secciones as $seccion) {
                foreach ($seccion->Matriculas as $matricula) {
                    foreach ($matricula->CronogramaPagos as $cronograma) {
                        if ($estado =='TODOS') {
                            if ($concepto_id==0&&($cronograma->estado()=='PENDIENTE'||$cronograma->estado()=='SALDO')) {
                                $alumno = [
                                    'id'=>$matricula->Alumno->id(),
                                    'matricula_id'=>$matricula->id(),
                                    'apellidos'=>$matricula->Alumno->apellidos(),
                                    'nombres'=>$matricula->Alumno->nombres(),
                                    'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                    'nivel'=>$seccion->Nivel->nivel(),
                                    'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                    'monto'=>self::CalcularSaldo($cronograma),
                                    'estado'=>$cronograma->estado(),
                                ];
                                //
                                array_push($alumnos, $alumno);
                            } else {
                                if($cronograma->ConceptoPago->id()==$concepto_id && ($cronograma->estado()=='PENDIENTE'||$cronograma->estado()=='SALDO')){
                                    $alumno = [
                                        'id'=>$matricula->Alumno->id(),
                                        'matricula_id'=>$matricula->id(),
                                        'apellidos'=>$matricula->Alumno->apellidos(),
                                        'nombres'=>$matricula->Alumno->nombres(),
                                        'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                        'nivel'=>$seccion->Nivel->nivel(),
                                        'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                        'monto'=>self::CalcularSaldo($cronograma),
                                        'estado'=>$cronograma->estado(),
                                    ];
                                    array_push($alumnos, $alumno);
                                }
                            }
                        }else {
                            if ($concepto_id==0 && $cronograma->estado()==$estado) {
                                $alumno = [
                                    'id'=>$matricula->Alumno->id(),
                                    'matricula_id'=>$matricula->id(),
                                    'apellidos'=>$matricula->Alumno->apellidos(),
                                    'nombres'=>$matricula->Alumno->nombres(),
                                    'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                    'nivel'=>$seccion->Nivel->nivel(),
                                    'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                    'monto'=>self::CalcularSaldo($cronograma),
                                    'estado'=>$cronograma->estado(),
                                ];
                                array_push($alumnos, $alumno);
                            } else {
                                if($cronograma->ConceptoPago->id()==$concepto_id && $cronograma->estado()==$estado){
                                    $alumno = [
                                        'id'=>$matricula->Alumno->id(),
                                        'matricula_id'=>$matricula->id(),
                                        'apellidos'=>$matricula->Alumno->apellidos(),
                                        'nombres'=>$matricula->Alumno->nombres(),
                                        'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                        'nivel'=>$seccion->Nivel->nivel(),
                                        'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                        'monto'=>self::CalcularSaldo($cronograma),
                                        'estado'=>$cronograma->estado(),
                                    ];
                                    array_push($alumnos, $alumno);
                                }
                            }
                        }
                    }
                }
            }
        }else {
            $seccion = Vacante::find($seccion_id);
            //dd($seccion);
            foreach ($seccion->Matriculas as $matricula) {
                foreach ($matricula->CronogramaPagos as $cronograma) {
                    if ($estado =='TODOS') {
                        if ($concepto_id==0&&($cronograma->estado()=='PENDIENTE'||$cronograma->estado()=='SALDO')) {
                            $alumno = [
                                'id'=>$matricula->Alumno->id(),
                                'matricula_id'=>$matricula->id(),
                                'apellidos'=>$matricula->Alumno->apellidos(),
                                'nombres'=>$matricula->Alumno->nombres(),
                                'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                'nivel'=>$seccion->Nivel->nivel(),
                                'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                'monto'=>self::CalcularSaldo($cronograma),
                                'estado'=>$cronograma->estado(),
                            ];
                            array_push($alumnos, $alumno);
                        } else {
                            if($cronograma->ConceptoPago->id()==$concepto_id && ($cronograma->estado()=='PENDIENTE'||$cronograma->estado()=='SALDO')){
                                $alumno = [
                                    'id'=>$matricula->Alumno->id(),
                                    'matricula_id'=>$matricula->id(),
                                    'apellidos'=>$matricula->Alumno->apellidos(),
                                    'nombres'=>$matricula->Alumno->nombres(),
                                    'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                    'nivel'=>$seccion->Nivel->nivel(),
                                    'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                    'monto'=>self::CalcularSaldo($cronograma),
                                    'estado'=>$cronograma->estado(),
                                ];
                                array_push($alumnos, $alumno);
                            }
                        }
                    }else {
                        if ($concepto_id==0 && $cronograma->estado()==$estado) {
                            $alumno = [
                                'id'=>$matricula->Alumno->id(),
                                'matricula_id'=>$matricula->id(),
                                'apellidos'=>$matricula->Alumno->apellidos(),
                                'nombres'=>$matricula->Alumno->nombres(),
                                'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                'nivel'=>$seccion->Nivel->nivel(),
                                'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                'monto'=>self::CalcularSaldo($cronograma),
                                'estado'=>$cronograma->estado(),
                            ];
                            array_push($alumnos, $alumno);
                        } else {
                            if($cronograma->ConceptoPago->id()==$concepto_id && $cronograma->estado()==$estado){
                                $alumno = [
                                    'id'=>$matricula->Alumno->id(),
                                    'matricula_id'=>$matricula->id(),
                                    'apellidos'=>$matricula->Alumno->apellidos(),
                                    'nombres'=>$matricula->Alumno->nombres(),
                                    'aula'=>$seccion->Grado->grado() . '° '.$seccion->Seccion->seccion(),
                                    'nivel'=>$seccion->Nivel->nivel(),
                                    'concepto'=>$cronograma->ConceptoPago->Concepto->concepto(),
                                    'monto'=>self::CalcularSaldo($cronograma),
                                    'estado'=>$cronograma->estado(),
                                ];
                                array_push($alumnos, $alumno);
                            }
                        }
                    }
                }
            }
        }
        return response()->json($this->ordenarArray->Ascendente($alumnos,'apellidos'));
    }
    private function CalcularSaldo($cronograma)
    {
        $monto = $cronograma->monto();
        foreach ($cronograma->Pagos as $pago) {
           $monto -= $pago->monto();
        }
        return $monto;
    }
    public function PagosEntreFechasView()
    {
        $usurios = User::where('USU_ESTADO', 'ACTIVO')->orderBy('USU_NOMBRES')->get();
        return view('pagos.pagos_entre_fechas')->with('usuarios',$usurios);
    }
    public function ObtenerPagosEntreFechas(Request $request)
    {
        $pagos=array();
        $fecha_inicial = date('Y-m-d\T00:00:00',strtotime($request->fecha_inicial));
        $fecha_final = date('Y-m-d\T23:59:59',strtotime($request->fecha_final));
        $usuario_id = $request->usuario_id;
        if ($usuario_id==0) {
            $pagos_aux = Pago::where('MP_PAGO_FECHA','>=', $fecha_inicial)->where('MP_PAGO_FECHA','<=', $fecha_final)->orderBy('MP_PAGO_FECHA')->get();
        } else {
            $pagos_aux = Pago::where('MP_PAGO_FECHA','>=', $fecha_inicial)->where('MP_PAGO_FECHA','<=', $fecha_final)->where('USU_ID','<=', $usuario_id)->orderBy('MP_PAGO_FECHA')->get();
        }
        foreach ($pagos_aux as $p ) {
            $pago = [
                'id'=>$p->id(),
                'fecha'=>date('d/m/Y H:i:s',strtotime($p->fecha())),
                'concepto'=>$p->ConceptoPago?$p->ConceptoPago->Concepto->concepto():$p->CronogramaPago->ConceptoPago->Concepto->concepto(),
                'tipo'=>$p->TipoComprobante->tipo(),
                'alumno'=>$p->Matricula->Alumno->apellidos().', '.$p->Matricula->Alumno->nombres(),
                'serie'=>$p->serie(),
                'numero'=>$p->numero(),
                'monto'=>$p->monto(),
                'usuario'=>$p->Usuario->nombres(),
            ];
            array_push($pagos, $pago);
        }
        return response()->json($pagos);
    }
}
