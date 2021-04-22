<?php
namespace App\Mappers;

use App\Ocupacion;
use App\ViewModel\OcupacionesViewModel;
use App\ViewModel\PaisViewModel;

class OcupacionMapper
{
    public function ModelToViewModel(Ocupacion $_ocupacion)
    {
        $_ocupacionVM = new OcupacionesViewModel();
        $_ocupacionVM->id =$_ocupacion->MP_OCU_ID;
        $_ocupacionVM->nombre =$_ocupacion->MP_OCU_NOMBRE;
        return $_ocupacionVM;
    }
    public function ListModelToViewModel($_ocupaciones)
    {
        $_listOcupaciones = [];
        foreach ($_ocupaciones as $ocupacion) {
            array_push($_listOcupaciones, self::ModelToViewModel($ocupacion));
        }
        return $_listOcupaciones;
    }
}
