<?php
namespace App\Mappers;

use App\Nivel;
use App\ViewModel\NivelViewModel;

class NivelMapper
{
    public function ModelToViewModel(Nivel $_nivel)
    {
        $_nivelVM = new NivelViewModel();
        $_nivelVM->id =$_nivel->MP_NIV_ID;
        $_nivelVM->nivel =$_nivel->MP_NIV_NIVEL;
        return $_nivelVM;
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
