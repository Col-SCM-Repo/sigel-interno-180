<?php

namespace App\Http\Controllers;

use App\Matricula;
use App\Pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
class ReportesController extends Controller
{
    public function VerBoleta($pago_id)
    {
        $pago=Pago::find($pago_id);
        $pdf = PDF::loadView('reportes.pdf.boleta', ['pago'=>$pago] )->setPaper( [0, 0, 220, 340]);
        return $pdf->stream('invoice.pdf');
    }
    public function DescargarListaAlumnos(Request $request)
    {
        return view('reportes.excel.aulas_con_alumnos')->with('alumnos',$request->alumnos)->with('seccion', $request->seccion)->with('anio', $request->anio);
    }
    public function DescargarResumen(Request $request)
    {
        $pagos = $request->pagos;
        $total = 0;
        $cant = 0;
        foreach ($pagos as $pago) {
            $total += $pago['monto'];
            $cant ++;
        }
        $pdf = PDF::loadView('reportes.pdf.resumen_pagos', ['total'=>$total, 'fecha'=>$request->fecha, 'cant'=>$cant] )->setPaper('a5');
        return $pdf->download('invoice.pdf');
    }
    //se puede eliminar si no se llega a usar
    // public function DescargarPagosDelDia(Request $request)
    // {
    //     $pdf = PDF::loadView('reportes.pdf.pagos_del_dia', ['pagos'=>$request->pagos, 'fecha'=>$request->fecha] );
    //     return $pdf->download('invoice.pdf');
    // }

    public function DescargarFichaMatricula($matricula_id)
    {
        $matricula = Matricula::find($matricula_id);
        $alumno = $matricula->Alumno;
        $padre = [];
        $madre = [];
        foreach($alumno->Parentescos as $pariente){
            if ($pariente->TipoParentesco->nombre()=='PADRE') {
                $padre = (object)[
                    'apellidos'=> $pariente->Apoderado->apellidos(),
                    'nombres'=> $pariente->Apoderado->nombres(),
                    'dni'=> $pariente->Apoderado->dni(),
                    'grado_instruccion'=> $pariente->Apoderado->GradoInstruccion->nombre(),
                    'ocupacion'=> $pariente->Apoderado->Ocupacion->nombre(),
                    'centro_laboral'=> $pariente->Apoderado->CentroLaboral->nombre(),
                    'fecha_nacimiento'=> date('d-m-Y',strtotime($pariente->Apoderado->fecha_nacimineto())),
                    'estado_civil'=> self::ObtenerEstadoCivil($pariente->Apoderado->estado_civil_id()),
                    'direccion'=> $pariente->Apoderado->direccion(),
                    'telefono'=> $pariente->Apoderado->telefono(),
                    'celular'=> $pariente->Apoderado->celular(),
                    'relacion' => $pariente->TipoParentesco->nombre()
                ];
            }
            if ($pariente->TipoParentesco->nombre()=='MADRE') {
                $madre = (object)[
                    'apellidos'=> $pariente->Apoderado->apellidos(),
                    'nombres'=> $pariente->Apoderado->nombres(),
                    'dni'=> $pariente->Apoderado->dni(),
                    'grado_instruccion'=> $pariente->Apoderado->GradoInstruccion->nombre(),
                    'ocupacion'=> $pariente->Apoderado->Ocupacion->nombre(),
                    'centro_laboral'=> $pariente->Apoderado->CentroLaboral->nombre(),
                    'fecha_nacimiento'=> date('d-m-Y',strtotime($pariente->Apoderado->fecha_nacimineto())),
                    'estado_civil'=> self::ObtenerEstadoCivil($pariente->Apoderado->estado_civil_id()),
                    'direccion'=> $pariente->Apoderado->direccion(),
                    'telefono'=> $pariente->Apoderado->telefono(),
                    'celular'=> $pariente->Apoderado->celular(),
                    'relacion' => $pariente->TipoParentesco->nombre()
                ];
            }
        }
        $responsable = (object)[
            'apellidos'=> $matricula->Patentesco->Apoderado->apellidos(),
            'nombres'=> $matricula->Patentesco->Apoderado->nombres(),
            'dni'=> $matricula->Patentesco->Apoderado->dni(),
            'grado_instruccion'=> $matricula->Patentesco->Apoderado->GradoInstruccion->nombre(),
            'ocupacion'=> $matricula->Patentesco->Apoderado->Ocupacion->nombre(),
            'centro_laboral'=> $matricula->Patentesco->Apoderado->CentroLaboral->nombre(),
            'fecha_nacimiento'=> date('d-m-Y',strtotime($matricula->Patentesco->Apoderado->fecha_nacimineto())),
            'estado_civil'=> self::ObtenerEstadoCivil($matricula->Patentesco->Apoderado->estado_civil_id()),
            'direccion'=> $matricula->Patentesco->Apoderado->direccion(),
            'telefono'=> $matricula->Patentesco->Apoderado->telefono(),
            'celular'=> $matricula->Patentesco->Apoderado->celular(),
            'relacion' => $matricula->Patentesco->TipoParentesco->nombre()
        ];
        $pdf = PDF::loadView('reportes.pdf.ficha_matricula', ['matricula'=>$matricula, 'alumno'=>$alumno, 'madre'=>$madre, 'padre'=>$padre, 'responsable'=>$responsable] )->setPaper('a4');
        return $pdf->stream('ficha_matricula.pdf');
    }
    public function DescargarCronograma($matricula_id)
    {
        setlocale(LC_ALL,"es_ES");
        Carbon::setLocale('es');
        $fecha_hoy = Carbon::parse(date('j F Y'));
        $matricula = Matricula::find($matricula_id);
        $alumno = $matricula->Alumno;
        $cronogramas = [];
        $i = 0;
        foreach ($matricula->CronogramaPagos as $crono) {
            $cronograma =(object)[
                'item'=> $i+1,
                'concepto'=> $crono->ConceptoPago->Concepto->concepto(),
                'monto'=> $crono->monto(),
                'fecha_vencimiento'=> $crono->fechaVencimiento(),
                'estado'=> $crono->estado(),
            ];
            array_push($cronogramas, $cronograma);
            $i++;
        }
        $pdf = PDF::loadView('reportes.pdf.cronograma', ['anio'=>$matricula->Vacante->AnioAcademico->nombre(), 'alumno'=>$alumno, 'cronogramas'=>$cronogramas, 'fecha_hoy'=>$fecha_hoy, 'matricula'=>$matricula] )->setPaper('a4');
        return $pdf->stream('ficha_matricula.pdf');
    }
    //mover a helpers
    private function ObtenerEstadoCivil($id)
    {
        $estado = '';
        switch ($id) {
            case '1':
                $estado = 'SOLTERO(A)';
                break;
            case '2':
                $estado = 'CASADO(A)';
                break;
            case '3':
                $estado = 'DIVORCIADO(A) / SEPARADO(A)';
                break;
            case '4':
                $estado = 'VIUDO(A)';
            break;
            case '5':
                $estado = 'CONVIVIENTE';
                break;
            case '6':
                $estado = 'NINGUNO';
                break;
            default:
                $estado = 'NINGUNO';
                break;
        }
        return $estado;
    }
}
