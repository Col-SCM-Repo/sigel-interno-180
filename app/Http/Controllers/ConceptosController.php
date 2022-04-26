<?php

namespace App\Http\Controllers;

use App\ConceptoPago;
use App\Helpers\OrdenarArray;
use App\Structure\Services\AnioAcademicoService;
use App\Structure\Services\ConceptoPagoService;
use App\Structure\Services\ConceptoService;
use App\Structure\Services\PagoService;
use Illuminate\Http\Request;

class ConceptosController extends Controller
{
    protected $ordenarArray;
    protected $_anioService;
    protected $_conceptoPagoService;
    protected $_pagoService;
    protected $_conceptoService;
    public function __construct(OrdenarArray $ordenarArray,
                                AnioAcademicoService $_anioService,
                                ConceptoPagoService $_conceptoPagoService,
                                PagoService $_pagoService,
                                ConceptoService $_conceptoService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_anioService = $_anioService;
        $this->_conceptoPagoService = $_conceptoPagoService;
        $this->_pagoService = $_pagoService;
        $this->_conceptoService = $_conceptoService;
    }
    public function ObtenerConceptosDelAnioActual()
    {
        $_anioVM = $this->_anioService->ObtenerAnioVigente();
        $_conceptosVM = $this->_conceptoPagoService->ObtenerConceptosPorAnio($_anioVM->id);
        $data=[
            'anio'=>$_anioVM,
            'conceptos'=>$_conceptosVM,
            'pagoModel'=>$this->_pagoService->CreaViewModel(0)
        ];
        return response()->json($data);
    }
    public function ObtenerConceptosPorAnioIDNivel(Request $request)
    {
        $conceptos=[];
        $aux = ConceptoPago::where('MP_ANIO_ID', $request->anio_id)->where('MP_CON_ID', '<=',11)->where('MP_NIV_ID', $request->nivel_id)->get();
        foreach ($aux as $c) {
           $concepto = [
                'concepto_pago_id'=>$c->id(),
                'concepto'=>$c->Concepto->concepto(),
                'monto'=>$c->monto()
           ];
           array_push($conceptos, $concepto);
        }
        return response()->json($this->ordenarArray->Ascendente($conceptos,'concepto'));
    }
    public function ObtenerConceptosPorAnio(Request $request)
    {
        return response()->json($this->_conceptoPagoService->ObtenerTodosConceptosPorAnio($request->anio_id));
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_conceptoService->ObtenerModelo());
    }
    public function ObtenerTodosConceptos()
    {
        return response()->json($this->_conceptoService->ObtenerConceptos());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_conceptoPagoService->Guardar((object) $request->concepto));

    }
}
