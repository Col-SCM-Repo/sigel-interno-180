<?php
namespace App\Mappers;

use App\Concepto;
use App\ConceptoPago;
use App\ViewModel\ConceptoViewModel;

class ConceptoMapper
{
    public function ConceptoPagoModelToViewModel(ConceptoPago $_conceptoPago, Concepto $_concepto)
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
            array_push($_listConceptos, self::ConceptoPagoModelToViewModel($concepto_pago, $concepto_pago->Concepto));
        }
        return $_listConceptos;
    }
    public function ViewModel()
    {
        return new ConceptoViewModel();
    }
    public function ConceptoModelToViewModel(Concepto $_concepto)
    {
        $_conceptoVM = new ConceptoViewModel();
        $_conceptoVM->id =$_concepto->MP_CON_ID;
        $_conceptoVM->concepto =$_concepto->MP_CON_CONCEPTO;
        $_conceptoVM->tipo_concepto_id =$_concepto->MP_TIPO_CON_ID;
        return $_conceptoVM;
    }
    public function ListConceptoModelToConceptoViewModel($_conceptos)
    {
        $_listConceptos = [];
        foreach ($_conceptos as $concepto) {
            array_push($_listConceptos, self::ConceptoModelToViewModel($concepto));
        }
        return $_listConceptos;
    }

    public function ViewModelToModelConceptoPago($_conceptoVM)
    {
        $_conceptoPagoM = new ConceptoPago();
        $_conceptoPagoM->MP_CONPAGO_ID = $_conceptoVM->concepto_pago_id==0?null:$_conceptoVM->concepto_pago_id ;
        $_conceptoPagoM->MP_CONPAGO_MONTO = $_conceptoVM->monto ;
        $_conceptoPagoM->MP_ANIO_ID = $_conceptoVM->anio_id ;
        $_conceptoPagoM->MP_NIV_ID = $_conceptoVM->nivel_id ;
        $_conceptoPagoM->MP_LOC_ID = $_conceptoVM->local_id ;
        $_conceptoPagoM->MP_CON_ID = $_conceptoVM->id ;
        $_conceptoPagoM->FECHA_VENCIMIENTO = date('Y-m-d',strtotime($_conceptoVM->fecha_vencimiento));
        return $_conceptoPagoM;
    }
}
