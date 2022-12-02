<?php
namespace App\ViewModel;

class CronogramaViewModel
{
    public $id =0;
    public $matricula_id = '';
    public $concepto_pago_id = '';
    public $tipo_deuda = '';
    public $estado = '';
    public $fecha_vencimiento = '';
    public $concepto = [];
    public $matricula = [];
    public $pagos = [];
    public $venido = [];
    public $alumno_id ='';
    public $monto_inicial = '';
    public $monto_cobrar = '';
    public $monto_descuento = '';
}
