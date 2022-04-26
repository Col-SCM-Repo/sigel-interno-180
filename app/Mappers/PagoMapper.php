<?php
namespace App\Mappers;

use App\Enums\ModalidadPagoEnum;
use App\Enums\TipoComprobanteEnum;
use App\Helpers\NumeroATexto;
use App\Pago;
use App\ViewModel\PagoViewModel;

class PagoMapper
{
    public function ModelToViewModel(Pago $_pago)
    {
        $_pagoVM = new PagoViewModel();
        $_pagoVM->id =$_pago->MP_PAGO_ID;
        $_pagoVM->matricula_id =$_pago->MP_MAT_ID;
        $_pagoVM->cronograma_id =$_pago->MP_CRO_ID;
        $_pagoVM->concepto_pago_id =$_pago->MP_CONPAGO_ID;
        $_pagoVM->serie_comprobante_id =$_pago->MP_SERCOM_ID;
        $_pagoVM->fecha = date('d-m-Y',strtotime($_pago->MP_PAGO_FECHA));
        $_pagoVM->monto =$_pago->MP_PAGO_MONTO;
        $_pagoVM->numero =$_pago->MP_PAGO_NRO;
        $_pagoVM->observacion =$_pago->MP_PAGO_OBS;
        $_pagoVM->tipo_comprobante_id =$_pago->MP_TIPCOM_ID;
        $_pagoVM->usuario_id =$_pago->USU_ID;
        $_pagoVM->serie =$_pago->MP_PAGO_SERIE;
        $_pagoVM->lee_monto =$_pago->MP_PAGO_LEE_MONTO;
        $_pagoVM->banco =$_pago->BANCO;
        $_pagoVM->numero_operacion =$_pago->NUMERO_OPERACION;
        $_pagoVM->fecha_emision = date('d-m-Y',strtotime($_pago->MP_PAGO_FECHAEMISION));;
        $_pagoVM->usuario_nombres =$_pago->Usuario->apellidos().', '.$_pago->Usuario->nombres();
        $_pagoVM->tipoPago =$_pago->BANCO? 'DEPOSITO':'EFECTIVO';

        return $_pagoVM;
    }
    public function ListModelToViewModel($_pagos)
    {
        $_listPagos = [];
        foreach ($_pagos as $pago) {
            array_push($_listPagos, self::ModelToViewModel($pago));
        }
        return $_listPagos;
    }
    public function ViewModel()
    {
        return new PagoViewModel();
    }
    public function ViewModelToModel($_pagoVM)
    {
        $_pagoModel =  new Pago();
        if ($_pagoVM->id!=0) {
            $_pagoModel->MP_PAGO_ID =$_pagoVM->id;
        }
        $_pagoModel->MP_MAT_ID =$_pagoVM->matricula_id;
        if (isset($_pagoVM->cronograma_id)) {
            $_pagoModel->MP_CRO_ID =$_pagoVM->cronograma_id;
        }
        $_pagoModel->MP_CONPAGO_ID =$_pagoVM->concepto_pago_id?$_pagoVM->concepto_pago_id:null;
        $_pagoModel->MP_SERCOM_ID = $_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::BoletaElectronica? $_pagoVM->serie_comprobante_id : null;
        $_pagoModel->MP_PAGO_FECHA =date('Y-m-d\TH:i:s',strtotime($_pagoVM->fecha . ' ' . date('H:i:s')));
        $_pagoModel->MP_PAGO_MONTO =$_pagoVM->monto;
        $_pagoModel->MP_PAGO_NRO =$_pagoVM->numero;
        $_pagoModel->MP_PAGO_OBS =mb_strtoupper($_pagoVM->observacion) ;
        $_pagoModel->MP_TIPCOM_ID =$_pagoVM->tipo_comprobante_id;
        $_pagoModel->USU_ID =$_pagoVM->usuario_id;
        $_pagoModel->MP_PAGO_SERIE =$_pagoVM->serie ;
        $_pagoModel->MP_PAGO_LEE_MONTO = $_pagoVM->monto>0? NumeroATexto::Soles($_pagoVM->monto):'Cero y 00/100 Soles';
        if ($_pagoVM->modalidad == ModalidadPagoEnum::Deposito ) {
            $_pagoModel->BANCO =$_pagoVM->banco;
            $_pagoModel->NUMERO_OPERACION =$_pagoVM->numero_operacion;
            $_pagoModel->MP_PAGO_FECHAEMISION =date('Y-m-d\TH:i:s',strtotime($_pagoVM->fecha_emision));
        }
        if ($_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::NotaDeCredito) {
            $_pagoModel->BANCO =$_pagoVM->banco;
            $_pagoModel->MP_PAGO_FECHAEMISION =date('Y-m-d\TH:i:s',strtotime($_pagoVM->fecha_emision));
        }
        return $_pagoModel;
    }
}
