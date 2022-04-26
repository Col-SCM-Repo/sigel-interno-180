<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Matricula;
use App\Pago;
use App\Structure\Services\AlumnoService;
use App\Structure\Services\AnioAcademicoService;
use App\Structure\Services\MatriculaService;
use App\Structure\Services\NivelService;
use App\Structure\Services\PagoService;
use App\Structure\Services\VacanteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class ReportesController extends Controller
{
    protected $_matriculaService;
    protected $_vacanteService;
    protected $_anioService;
    protected $_nivelService;
    protected $_alumnoService;
    protected $_pagoService;
    protected $_ordenarArray;
    public function __construct(MatriculaService $_matriculaService,
                                VacanteService $_vacanteService,
                                AnioAcademicoService $_anioService,
                                NivelService $_nivelService,
                                AlumnoService $_alumnoService,
                                PagoService $_pagoService,
                                OrdenarArray $_ordenarArray)
    {
        $this->_matriculaService = $_matriculaService;
        $this->_vacanteService = $_vacanteService;
        $this->_anioService = $_anioService;
        $this->_nivelService = $_nivelService;
        $this->_alumnoService = $_alumnoService;
        $this->_pagoService = $_pagoService;
        $this->_ordenarArray = $_ordenarArray;
    }
    #funciones corregidas
    public function DescargarMatriculasPorAula(Request $request)
    {
        $matriculas =  $this->_matriculaService->ObtenerMatriculasPorAula($request->aula_id);
        $vacante = $this->_vacanteService->BuscarPorId($request->aula_id);
        return view('reportes.excel.matriculas_por_alua')->with('matriculas', $this->_ordenarArray->Ascendente($matriculas,'nombres_alumno'))->with('vacante', $vacante);
    }
    public function DescargarListaSecciones(Request $request)
    {
        $_anio = $this->_anioService->BuscarPorId($request->anio_id);
        $_aulas = $this->_vacanteService->ObtenerAulasPorAnioNivel($request->anio_id,$request->nivel_id);
        $_nivel  = $this->_nivelService->BuscarPorId($request->nivel_id);
        $total_vacantes =0;
        $vacantes_ocupadas =0;
        $vacantes_disponibles =0;
        foreach ($_aulas as $aula) {
            if ($aula->vacantes_ocupadas>0) {
                $total_vacantes += $aula->total_vacantes;
                $vacantes_ocupadas += $aula->vacantes_ocupadas;
                $vacantes_disponibles += $aula->vacantes_disponibles;
            }
        }
        $pdf = PDF::loadView('reportes.pdf.secciones_nivel_anio', ['aulas'=>$_aulas, 'nivel'=>$_nivel, 'anio'=>$_anio, 'total_vacantes'=>$total_vacantes, 'vacantes_disponibles'=>$vacantes_disponibles, 'vacantes_ocupadas'=>$vacantes_ocupadas] )->setPaper('a4');
        return $pdf->download('Lista de secciones.pdf');
    }
    public function GenerarCarnetAlumno($matricula_id)
    {
        $_matriculaVM = $this->_matriculaService->ObtenerDatosCarnet($matricula_id);
        $pdf = PDF::loadview('reportes.pdf.alumno.carnet',['matricula'=>$_matriculaVM])->setPaper( [0, 0, 156.132, 245.230],'landscape');
        return $pdf->stream();
    }
    public function GenerarCarnetAula($vacante_id)
    {
        $_matriculasVM = $this->_matriculaService->ObtenerDatosCarnetPorVacante($vacante_id);
        $pdf = PDF::loadview('reportes.pdf.aula.carnets',['matriculas'=>$_matriculasVM])->setPaper( [0, 0, 156.132, 245.230],'landscape');
        return $pdf->stream();
    }
    public function DescargarListaAlumnosMorososPDF(Request $request)
    {
        $totalSaldo=0;
        $_listaAlumnosVM = $this->_pagoService->ObtenerAlumnosMorosos($request->anio_id,$request->nivel_id,$request->seccion_id,$request->concepto_id,$request->estado);
        foreach ($_listaAlumnosVM as $_alumnoVM) {
           $totalSaldo += $_alumnoVM->saldo;
        }
        $pdf = PDF::loadView('reportes.pdf.alumnos_morosos', ['alumnos'=>$this->_ordenarArray->AscendenteDosCampos($_listaAlumnosVM, 'aula','apellidos'), 'totalSaldo'=>$totalSaldo] )->setPaper('a4');
        return $pdf->download('Lista Alumno Morosos.pdf');
    }
    public function DescargarListaAlumnosMorososExcel(Request $request)
    {
        $totalSaldo=0;
        $_listaAlumnosVM = $this->_pagoService->ObtenerAlumnosMorosos($request->anio_id,$request->nivel_id,$request->seccion_id,$request->concepto_id,$request->estado);
        foreach ($_listaAlumnosVM as $_alumnoVM) {
           $totalSaldo += $_alumnoVM->saldo;
        }
        return view('reportes.excel.alumnos_morosos')->with('alumnos',$this->_ordenarArray->AscendenteDosCampos($_listaAlumnosVM, 'aula','apellidos'))->with('totalSaldo', $totalSaldo);
    }
    public function VerBoleta($pago_id)
    {
        $pago=Pago::find($pago_id);
        $pdf = PDF::loadView('reportes.pdf.boleta', ['pago'=>$pago] )->setPaper( [0, 0, 220, 340]);
        return $pdf->stream('invoice.pdf');
    }
    #funciones por corregir
    public function DescargarResumen(Request $request)
    {
        $pagos = $request->pagos;
        $total_efectivo = 0;
        $total_deposito = 0;
        $cant = 0;
        foreach ($pagos as $pago) {
            //dd($pago);
            if ($pago['tipoPago']=="EFECTIVO") {
                $total_efectivo += $pago['monto'];
            } else {
                $total_deposito += $pago['monto'];
            }
            $cant ++;
        }
        $pdf = PDF::loadView('reportes.pdf.resumen_pagos', ['total_efectivo'=>$total_efectivo, 'total_deposito'=>$total_deposito,'fecha'=>$request->fecha, 'cant'=>$cant] )->setPaper('a5');
        return $pdf->download('invoice.pdf');
    }

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


    public function DescargarPagosEntreFechasPDF(Request $request)
    {
        $pdf = PDF::loadView('reportes.pdf.pagos_entre_fechas', ['pagos'=>$request->pagos, 'fecha_inicial'=>$request->fecha_inicial, 'fecha_final'=>$request->fecha_final] )->setPaper('a4');
        return $pdf->download('Lista Alumno Morosos.pdf');
    }
    public function DescargarPagosEntreFechasExcel(Request $request)
    {
        return view('reportes.excel.pagos_entre_fechas')->with('pagos',$request->pagos)->with('fecha_inicial', $request->fecha_inicial)->with('fecha_final', $request->fecha_final);
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
