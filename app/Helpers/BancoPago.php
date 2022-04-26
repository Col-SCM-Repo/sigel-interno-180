<?php
namespace App\Helpers;
class BancoPago{
    public static function ObtenerBanco($numero)
    {
        $banco = null;
        switch ($numero) {
            case 1:
                $banco = "BCP";
                break;
            case 2:
                $banco = "BBVA";
                break;
            default:
                $banco = null;
                break;
        }
        return $banco;
    }
}
