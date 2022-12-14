<?php
namespace App\Helpers;

use NumberFormatter;

class NumeroATexto{
    public static function Soles($numero)
    {
        $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
        $izquierda = intval(floor($numero));
        $derecha = intval(($numero - floor($numero)) * 100);
        if ($derecha<10) {
            $derecha='0'.$derecha;
        } else if($derecha=0) {
            $derecha='00';
        }
        return ucfirst($formatterES->format($izquierda)) . " y " . $derecha.'/100 Soles';
    }
}
