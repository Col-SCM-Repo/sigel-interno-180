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
        $_cronogramaVM->fecha_vencimiento = date('d-m-Y',strtotime($_cronograma->MP_CRO_FECHAVEN));
        $_cronogramaVM->tipo_deuda =$_cronograma->MP_CRO_TIPODEUDA;
        $_cronogramaVM->estado =$_cronograma->MP_CRO_ESTADO;
        $_cronogramaVM->vencido =strtotime($_cronograma->MP_CRO_FECHAVEN)<strtotime(date('d-m-Y'))?true:false;
        $_cronogramaVM->alumno_id = $_cronograma->Matricula->MP_ALU_ID;
        $_cronogramaVM->monto_inicial =$_cronograma->montoInicial();
        $_cronogramaVM->monto_cobrar =$_cronograma->montoCobrar();
        $_cronogramaVM->monto_descuento =$_cronograma->montoDescuento();
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
        $_cronogramaModel->MP_CRO_FECHAVEN = date('Y-m-d\T00:00:00',strtotime($_cronogramaVM->fecha_vencimiento)) ;
        $_cronogramaModel->MP_CRO_TIPODEUDA = $_cronogramaVM->tipo_deuda ;
        $_cronogramaModel->MP_CRO_ESTADO = $_cronogramaVM->estado ;
        $_cronogramaModel->MP_CRO_MONTO = $_cronogramaVM->monto_inicial ;
        $_cronogramaModel->MONTO_COBRAR = $_cronogramaVM->monto_cobrar ;
        $_cronogramaModel->MONTO_DESCUENTO = $_cronogramaVM->monto_descuento ;
        return $_cronogramaModel;
    }
    public function ViewModel()
    {
        return new CronogramaViewModel();
    }
}
