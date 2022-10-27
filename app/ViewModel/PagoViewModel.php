<?php
namespace App\ViewModel;

class PagoViewModel
{
    public $id = 0;
    public $matricula_id = '';
    public $nombres_alumno = '';
    public $cronograma_id = '';
    public $concepto_pago_id = '';
    public $concepto = '';
    public $nombre_concepto = '';
    public $serie_comprobante_id = '';
    public $fecha = '';
    public $monto = '';
    public $saldo = '';
    public $numero = '';
    public $observacion = '';
    public $tipo_comprobante_id = 8;
    public $tipo_comprobante = '';
    public $usuario_id = '';
    public $usuario = '';
    public $serie = '';
    public $lee_monto = '';
    public $banco = '';
    public $numero_operacion = '';
    public $fecha_emision = '';
    public $usuario_nombres = '';
    public $modalidad = 1;
    public $tipoPago='';
    public $responsables_pago=[];
    public $responsable_pago_id='';
    public $ruc = '';
    public $razon_social='';
}
