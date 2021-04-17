<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\ConceptoPago;
use App\CronogramaPago;
use App\Helpers\OrdenarArray;
use App\Matricula;
use App\Structure\Services\MatriculaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatriculasController extends Controller
{
    protected $ordenarArray;
    protected $_matriculaService;
    public function __construct(OrdenarArray $ordenarArray,
                                MatriculaService $_matriculaService)
    {
       $this->ordenarArray = $ordenarArray;
       $this->_matriculaService = $_matriculaService;
    }
    public function ObtenerMatriculasPorAlumno(Request $request)
    {
        $_listMatriculas = $this->_matriculaService->ObtenerMatriculasPorAlumno($request->alumno_id);
        return response()->json($_listMatriculas);
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
                'fecha' => date('Y-m-d H:i:s')
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
                'estado' => self::obtenerEstadoLetrasANum($aux->estado()),
                'vacante_id' =>  $aux->vacante_id(),
                'nivel' => $aux->Vacante->Nivel->id(),
                'grado' => $aux->Vacante->Grado->id(),
                'monto_matricula' => '',
                'monto_pension' => '',
                'fecha' => date('Y-m-d H:i:s',strtotime($aux->fecha()))
            ];
        }

        return $matricula;
    }

    public function Guardar(Request $request)
    {
        try {
            $matricula = (object)$request->matricula;
            //dd($matricula);
            if ($matricula->id!=0) {
                $matricula_aux = Matricula::find($matricula->id);
            } else {
                $matricula_aux = new Matricula();
            }
            $matricula_aux->MP_PAR_ID = $matricula->pariente_id;
            $matricula_aux->MP_ALU_ID = $matricula->alumno_id;
            $matricula_aux->MP_TIPMAT_ID = $matricula->tipo_id;
            $matricula_aux->MP_MAT_OBS = $matricula->observacion;
            $matricula_aux->MP_IEPRO_ID = $matricula->ie_procedencia_id;
            $matricula_aux->MP_MAT_ESTADO = self::obtenerEstadoNumAletras($matricula->estado);
            $matricula_aux->MP_VAC_ID =  $matricula->vacante_id;
            $matricula_aux->MP_MAT_MONTOPENSION =  0;
            $matricula_aux->MP_MAT_FECHAMATRICULA = date('Y-m-d\TH:i:s',strtotime($matricula->fecha));
            $matricula_aux->USU_ID = Auth::user()->id();
            $matricula_aux->save();
            //si la matricula ($matricula->id = 0) es nueva creamos el cronograma
            if ($matricula->id ==0) {
                $anio_academico_actual = AnioAcademico::where('MP_ANIO_ESTADO', 'VIGENTE')->first();
                $concepto_pagos = ConceptoPago::where('MP_ANIO_ID',$anio_academico_actual->id())->where('MP_CON_ID','<=',11)->where('MP_NIV_ID',$matricula->nivel)->get();
                foreach ($concepto_pagos as $concepto ) {
                    $cronograma=new CronogramaPago();
                    $cronograma->MP_CRO_ID =CronogramaPago::select('MP_CRO_ID')->max('MP_CRO_ID');
                    $cronograma->MP_MAT_ID=$matricula_aux->id();
                    $cronograma->MP_CONPAGO_ID=$concepto->id();
                    $cronograma->MP_CRO_FECHAVEN=date('Y-m-d\TH:i:s',strtotime($concepto->fecha_vencimiento()));
                    $cronograma->MP_CRO_ESTADO= $concepto->concepto_id()==1?('PENDIENTE'):($matricula->tipo_id==2?('EXONERADO'):('PENDIENTE'));
                    $cronograma->MP_CRO_TIPODEUDA= $concepto->concepto_id()==1? 'DERECHO DE PAGO':'PENSION';
                    $cronograma->MP_CRO_MONTO = $concepto->concepto_id()==1? ($matricula->monto_matricula!=''?$matricula->monto_matricula:($concepto->monto())):($matricula->monto_pension!=''?$matricula->monto_pension:($matricula->tipo_id==3?($concepto->monto()/2):$concepto->monto()));
                    $aux_max = $cronograma->MP_CRO_ID;
                    while ($cronograma->MP_CRO_ID==$aux_max) {
                        $aux_max = CronogramaPago::select('MP_CRO_ID')->max('MP_CRO_ID');
                        $cronograma->MP_CRO_ID++;
                        if ($cronograma->MP_CRO_ID!=$aux_max) {
                            $cronograma->save();
                        }
                    }
                }
            }else{
                $cronogramas = $matricula_aux->CronogramaPagos;
                foreach ($cronogramas as $cronograma) {
                    $cronograma->MP_CRO_MONTO = $cronograma->ConceptoPago->concepto_id()==1? ($matricula->monto_matricula!=''?$matricula->monto_matricula:$cronograma->monto()):($matricula->monto_pension!=''?$matricula->monto_pension:$cronograma->monto());
                    $cronograma->save();
                }
            }
            return $matricula_aux->id();
        } catch (\Throwable $th) {
            return response()->json($th,401);
        }
    }
    private function obtenerEstadoLetrasANum($estado)
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
    private function obtenerEstadoNumAletras($estado)
    {
        $estado_num="NORMAL";
        switch ($estado_num) {
            case 1:
                $estado_num = "NUEVO";
                break;
            case 2:
                $estado_num = "NORMAL";
                break;
            case 3:
                $estado_num = "PRIMERA MATRICULA";
                break;
            case 4:
                $estado_num = "RETIRADO";
                break;
            case 5:
                $estado_num = "ABANDONO";
                break;
            default:
                # code...
                break;
        }
        return $estado_num;
    }
}
