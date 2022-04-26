<?php
namespace App\Mappers;

use App\Local;
use App\ViewModel\LocalViewModel;

class LocalMapper
{
    public function ModelToViewModel(Local $_local)
    {
        $_localVM = new LocalViewModel();
        $_localVM->id =$_local->MP_LOC_ID;
        $_localVM->nombre =$_local->MP_LOC_NOM;
        $_localVM->direccion =$_local->MP_LOC_DIR;
        $_localVM->observacion =$_local->MP_LOC_OBS;
        return $_localVM;
    }
    public function ListModelToViewModel($_niveles)
    {
        $_listNiveles = [];
        foreach ($_niveles as $nivel) {
            array_push($_listNiveles, self::ModelToViewModel($nivel));
        }
        return $_listNiveles;
    }
}
