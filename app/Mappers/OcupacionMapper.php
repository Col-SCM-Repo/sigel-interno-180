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
    public function ViewModel()
    {
        return new OcupacionesViewModel();
    }
    public function ViewModelToModel($_ocupacionVM)
    {
        $_ocupacionM = new Ocupacion();
        if ($_ocupacionVM->id!=0) {
            $_ocupacionM->MP_OCU_ID = $_ocupacionVM->id;
        }
        $_ocupacionM->MP_OCU_NOMBRE = mb_strtoupper($_ocupacionVM->nombre);
        return $_ocupacionM;
    }
}
