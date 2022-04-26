<?php
namespace App\Mappers;

use App\Enums\ModalidadPagoEnum;
use App\Enums\TipoComprobanteEnum;
use App\Helpers\NumeroATexto;
use App\Pago;
use App\ViewModel\PagoEntreFechasViewModel;
use App\ViewModel\PagoViewModel;

class PagoEntreFechasMapper
{
    public function ModelToViewModel(Pago $_pago)
    {
        $_pagoVM = new PagoEntreFechasViewModel();
        $_pagoVM->id =$_pago->id();
        $_pagoVM->fecha =date('d/m/Y H:i:s',strtotime($_pago->fecha()));
        $_pagoVM->concepto =$_pago->ConceptoPago?$_pago->ConceptoPago->Concepto->concepto():$_pago->CronogramaPago->ConceptoPago->Concepto->concepto();
        $_pagoVM->tipo =$_pago->TipoComprobante->tipo();
        $_pagoVM->alumno =$_pago->Matricula->Alumno->apellidos().', '.$_pago->Matricula->Alumno->nombres();
        $_pagoVM->serie = $_pago->serie();
        $_pagoVM->numero =$_pago->numero();
        $_pagoVM->monto =$_pago->monto();
        $_pagoVM->usuario =$_pago->Usuario->nombres();
        $_pagoVM->tipoPago =$_pago->BANCO? 'DEPOSITO':'EFECTIVO';
        return $_pagoVM;
    }
}
