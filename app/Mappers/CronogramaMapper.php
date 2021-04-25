<?php
namespace App\Mappers;

use App\CronogramaPago;
use App\ViewModel\CronogramaViewModel;

class CronogramaMapper
{
    public function ModelToViewModel(CronogramaPago $_cronograma)
    {
        $_cronogramaVM = new CronogramaViewModel();
        $_cronogramaVM->id =$_cronograma->MP_CRO_ID;
        $_cronogramaVM->matricula_id =$_cronograma->MP_MAT_ID;
        $_cronogramaVM->concepto_pago_id =$_cronograma->MP_CONPAGO_ID;
        $_cronogramaVM->fecha_vencimiento = date('Y-m-d H:i:s',strtotime($_cronograma->MP_CRO_FECHAVEN));
        $_cronogramaVM->tipo_deuda =$_cronograma->MP_CRO_TIPODEUDA;
        $_cronogramaVM->monto =$_cronograma->MP_CRO_MONTO;
        $_cronogramaVM->estado =$_cronograma->MP_CRO_ESTADO;
        return $_cronogramaVM;
    }
    public function ListModelToViewModel($_cronogramas)
    {
        $_listCronogramas = [];
        foreach ($_cronogramas as $cronograma) {
            array_push($_listCronogramas, self::ModelToViewModel($cronograma));
        }
        return $_listCronogramas;
    }
    public function ViewModelToModel($_cronogramaVM)
    {
        $_cronogramaModel = new CronogramaPago();
        if($_cronogramaVM->id!=0){
            $_cronogramaModel->MP_CRO_ID = $_cronogramaVM->id;
        }
        $_cronogramaModel->MP_MAT_ID = $_cronogramaVM->matricula_id;
        $_cronogramaModel->MP_CONPAGO_ID = $_cronogramaVM->concepto_pago_id;
        $_cronogramaModel->MP_CRO_FECHAVEN = date('Y-m-d\TH:i:s',strtotime($_cronogramaVM->fecha_vencimiento)) ;
        $_cronogramaModel->MP_CRO_TIPODEUDA = $_cronogramaVM->tipo_deuda ;
        $_cronogramaModel->MP_CRO_MONTO = $_cronogramaVM->monto ;
        $_cronogramaModel->MP_CRO_ESTADO = $_cronogramaVM->estado ;
        return $_cronogramaModel;
    }
    public function ViewModel()
    {
        return new CronogramaViewModel();
    }
}
