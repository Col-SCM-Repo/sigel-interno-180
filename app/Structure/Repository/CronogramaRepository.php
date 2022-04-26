<?php
namespace App\Structure\Repository;

use App\CronogramaPago;

class CronogramaRepository extends CronogramaPago
{
    public function Actualizar($cronogramaM)
    {
        $actualizarCronograma = CronogramaPago::find($cronogramaM->id());
        $actualizarCronograma->MP_MAT_ID = $cronogramaM->MP_MAT_ID;
        $actualizarCronograma->MP_CONPAGO_ID =$cronogramaM->MP_CONPAGO_ID ;
        $actualizarCronograma->MP_CRO_FECHAVEN =$cronogramaM->MP_CRO_FECHAVEN;
        $actualizarCronograma->MP_CRO_TIPODEUDA =$cronogramaM->MP_CRO_TIPODEUDA ;
        $actualizarCronograma->MP_CRO_MONTO = $cronogramaM->MP_CRO_MONTO;
        $actualizarCronograma->MP_CRO_ESTADO =$cronogramaM->MP_CRO_ESTADO ;
        $actualizarCronograma->save();
        return $actualizarCronograma->id();
    }
    public function Crear($cronogramaM)
    {
        $nuevoCronograma = new CronogramaPago();
        $nuevoCronograma = $cronogramaM;
        $nuevoCronograma->save();
        return $nuevoCronograma->id();
    }
    public function ObtenerUltimoId()
    {
        return CronogramaPago::select('MP_CRO_ID')->max('MP_CRO_ID');
    }
    public function BuscarPorMatriculaId($matricula_id)
    {
        return $this::where('MP_MAT_ID',$matricula_id)->get();
    }
    public function BuscarPorId($_cronogramaId)
    {
        return $this::find($_cronogramaId);
    }
}
