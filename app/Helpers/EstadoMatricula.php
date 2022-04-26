<?php
namespace App\Helpers;

use App\Structure\Services\AnioAcademicoService;

class EstadoMatricula{
    public static function ANumero($estado)
    {
        switch ($estado) {
            case "NUEVO":
                $estado_num = 1;
                break;
            case "NORMAL":
                $estado_num = 2;
                break;
            case "PRIMERA MATRICULA":
                $estado_num = 3;
                break;
            case "RETIRADO":
                $estado_num = 4;
                break;
            case "ABANDONO":
                $estado_num = 5;
                break;
            default:
                $estado_num=2;
                break;
        }
        return $estado_num;
    }
    public static function ALetras($estado)
    {
        switch ($estado) {
            case 1:
                $estado_letras = "NUEVO";
                break;
            case 2:
                $estado_letras = "NORMAL";
                break;
            case 3:
                $estado_letras = "PRIMERA MATRICULA";
                break;
            case 4:
                $estado_letras = "RETIRADO";
                break;
            case 5:
                $estado_letras = "ABANDONO";
                break;
            default:
                $estado_letras="NORMAL";
                break;
        }
        return $estado_letras;
    }
    public static function PueedeRetirarse($anio_id)
    {
        $anioService = new AnioAcademicoService();
        $anioactual = $anioService->ObtenerAnioVigente();
        if ($anio_id == $anioactual->id) {
            return true;
        } else {
            return false;
        }

    }
}
