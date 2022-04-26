<?php
namespace App\Structure\Repository;

use App\ConceptoPago;

class ConceptoPagoRepository extends ConceptoPago
{
    public function BuscarPorAnioYNivel($anio_id,$nivel_id)
    {
        return $this::where('MP_ANIO_ID',$anio_id)->where('MP_NIV_ID',$nivel_id)->get();
    }
    public function BuscarPorId($conceptoPagoId)
    {
        return $this::find($conceptoPagoId);
    }
    public function BuscarOtrosConceptosPorAnio($anio_id)
    {
        return $this::where('MP_ANIO_ID', $anio_id)->where('MP_CON_ID', '>',11)->get();
    }
    public function BuscarConceptosPorAnio($anio_id)
    {
        return $this::where('MP_ANIO_ID', $anio_id)->get();
    }
    public function Crear($conceptoPagoM)
    {
        $nuevoConceptoPago = new ConceptoPago();
        $nuevoConceptoPago->MP_CONPAGO_MONTO = $conceptoPagoM->MP_CONPAGO_MONTO ;
        $nuevoConceptoPago->MP_ANIO_ID = $conceptoPagoM->MP_ANIO_ID ;
        $nuevoConceptoPago->MP_CON_ID = $conceptoPagoM->MP_CON_ID ;
        $nuevoConceptoPago->MP_NIV_ID = $conceptoPagoM->MP_NIV_ID ;
        $nuevoConceptoPago->MP_LOC_ID = $conceptoPagoM->MP_LOC_ID ;
        $nuevoConceptoPago->FECHA_VENCIMIENTO = $conceptoPagoM->FECHA_VENCIMIENTO;
        $nuevoConceptoPago->save();
        return $nuevoConceptoPago->id();
    }
    public function Actualizar($conceptoPagoM)
    {
        $actualizarConceptoPago = ConceptoPago::find($conceptoPagoM->id());
        $actualizarConceptoPago->MP_CONPAGO_MONTO = $conceptoPagoM->MP_CONPAGO_MONTO ;
        $actualizarConceptoPago->MP_ANIO_ID = $conceptoPagoM->MP_ANIO_ID ;
        $actualizarConceptoPago->MP_CON_ID = $conceptoPagoM->MP_CON_ID ;
        $actualizarConceptoPago->MP_NIV_ID = $conceptoPagoM->MP_NIV_ID ;
        $actualizarConceptoPago->MP_LOC_ID = $conceptoPagoM->MP_LOC_ID ;
        $actualizarConceptoPago->FECHA_VENCIMIENTO = $conceptoPagoM->FECHA_VENCIMIENTO;
        $actualizarConceptoPago->save();
        return $actualizarConceptoPago->id();
    }
}
