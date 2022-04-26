<?php
namespace App\Helpers;

use App\CronogramaPago;

class CronogramaHelper{
    public static function CalcularSaldo(CronogramaPago $_cronogramaM)
    {
        $saldo = $_cronogramaM->monto();
        foreach ($_cronogramaM->Pagos as $_pagoM) {
           $saldo -= $_pagoM->monto();
        }
        return $saldo;
    }
    public static function EstadoTexto($_estadoNum)
    {
        $_estadoTexto = '';
        switch ($_estadoNum) {
            case 1:
                $_estadoTexto = 'SALDO';
                break;
            case 2:
                $_estadoTexto = 'PENDIENTE';
                break;
            case 3:
                $_estadoTexto = '';
                break;
            case 4:
                $_estadoTexto = '';
                break;
            default:
               # code...
                break;
        }
        return $_estadoTexto;
    }
}
