<?php
namespace App\Helpers;
class TipoComprobante{
    public static function Atexto($tipo)
    {
        switch ($tipo) {
            case 1:
                $estado_letras = "TICKET";
                break;
            case 2:
                $estado_letras = "BOLETA";
                break;
            case 3:
                $estado_letras = "RECIBO";
                break;
            case 4:
                $estado_letras = "FACTURA";
                break;
            case 5:
                $estado_letras = "NOTA DE CREDITO";
                break;
            case 6:
                $estado_letras = "VOUCHER";
                break;
            case 7:
                $estado_letras = "-------";
                break;
            case 8:
                $estado_letras = "BOLETA ELECTRONICA";
                break;
            default:
                $estado_letras="";
                break;
        }
        return $estado_letras;
    }
}
