<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\PagoService;
use App\User;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    private $ordenarArray;
    private $_pagoService;
    public function __construct(OrdenarArray $ordenarArray                                ,
                                PagoService $_pagoService)
    {
        $this->ordenarArray=$ordenarArray;
        $this->_pagoService=$_pagoService;
    }
    public function ObtenerPagosPorCronogramaId(Request $request)
    {
        return response()->json($this->_pagoService->ObtenerPagosPorCronograma($request->cronograma_id));
    }
    public function ObtenerModelo($cronograma_id)
    {
        return response()->json($this->_pagoService->CreaViewModel($cronograma_id));
    }
    public function GuardarPago(Request $request)
    {
        return $this->_pagoService->GuardarPago((object)$request->pago);
    }
    public function GuardarNotaCredito(Request $request)
    {
        return $this->_pagoService->GuardarNotaCredito((object)$request->pago,$request->pago_anteror_id);
    }
    public function PagosPorOtrosConceptosPorMatriula(Request $request)
    {
        return $this->_pagoService->ObtenerPagosPorOtrosConceptoPorMatricula($request->matricula_id);
    }
    public function PagosPorFechaUsuarioActual()
    {
        return view('modulos.pagosMatriculas.pagos.fecha_por_usuario_actual');
    }
    public function ObtenerPagosPorFechaUsuarioActual(Request $request)
    {
        return $this->_pagoService->ObtenerPagosPorFechaUsuarioActual($request->fecha);
    }
    public function ObtenerAlumnosMorosos(Request $request)
    {
        $_listaAlumnosMorosos = $this->_pagoService->ObtenerAlumnosMorosos($request->anio_id,$request->nivel_id,$request->seccion_id,$request->concepto_id,$request->estado);
        return $this->ordenarArray->AscendenteDosCampos($_listaAlumnosMorosos, 'aula','apellidos');
    }
    public function PagosEntreFechasView()
    {
        $usurios = User::where('USU_ESTADO', 'ACTIVO')->orderBy('USU_NOMBRES')->get();
        return view('modulos.pagosMatriculas.pagos.pagos_entre_fechas')->with('usuarios',$usurios);
    }
    public function ObtenerPagosEntreFechas(Request $request)
    {
        return $this->_pagoService->ObtenerPagosEntreFechas(date('Y-m-d\T00:00:00',strtotime($request->fecha_inicial)),date('Y-m-d\T23:59:59',strtotime($request->fecha_final)),$request->usuario_id);
    }
    public function ValidarPago(Request $request)
    {
        return $this->_pagoService->ValidarPago((object)$request->pago);
    }
}
