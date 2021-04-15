<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\ConceptoPago;
use App\Helpers\OrdenarArray;
use Illuminate\Http\Request;

class ConceptosController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray = $ordenarArray;
    }
    public function ObtenerConceptosDelAnioActual()
    {
        $conceptos=[];
        $anio = AnioAcademico::where('MP_ANIO_ESTADO','VIGENTE')->first();
        $aux = ConceptoPago::where('MP_ANIO_ID', $anio->id())->where('MP_CON_ID', '>',11)->get();
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
    public function ObtenerConceptosPorAnioIDNivel(Request $request)
    {
        $conceptos=[];
        $anio = AnioAcademico::find($request->anio_id);
        $aux = ConceptoPago::where('MP_ANIO_ID', $anio->id())->where('MP_CON_ID', '<=',11)->where('MP_NIV_ID', $request->nivel_id)->get();
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
}
