<?php
namespace App\Mappers;

use App\Concepto;
use App\ConceptoPago;
use App\ViewModel\ConceptoViewModel;

class ConceptoMapper
{
    public function ModelToViewModel(ConceptoPago $_conceptoPago, Concepto $_concepto)
    {
        $_conceptoVM = new ConceptoViewModel();
        $_conceptoVM->id =$_concepto->MP_CON_ID;
        $_conceptoVM->concepto =$_concepto->MP_CON_CONCEPTO;
        $_conceptoVM->tipo_concepto_id =$_concepto->MP_TIPO_CON_ID;
        $_conceptoVM->concepto_pago_id =$_conceptoPago->MP_CONPAGO_ID;
        $_conceptoVM->monto =$_conceptoPago->MP_CONPAGO_MONTO;
        $_conceptoVM->anio_id =$_conceptoPago->MP_ANIO_ID;
        $_conceptoVM->nivel_id =$_conceptoPago->MP_NIV_ID;
        $_conceptoVM->local_id =$_conceptoPago->MP_LOC_ID;
        $_conceptoVM->fecha_vencimiento = date('Y-m-d',strtotime($_conceptoPago->FECHA_VENCIMIENTO));
        return $_conceptoVM;
    }
    public function ListConceptoPagoModelToConceptoViewModel($_conceptosPagos)
    {
        $_listConceptos = [];
        foreach ($_conceptosPagos as $concepto_pago) {
            array_push($_listConceptos, self::ModelToViewModel($concepto_pago, $concepto_pago->Concepto));
        }
        return $_listConceptos;
    }
}
