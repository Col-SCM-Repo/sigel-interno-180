<?php
namespace App\Mappers;

use App\Apoderado;
use App\Parentesco;
use App\ViewModel\ApoderadoViewModel;
use App\ViewModel\NivelViewModel;

class ApoderadoMapper
{
    public function ModelToViewModel(Parentesco $_parentesco, Apoderado $_apoderado)
    {
        $_apoderadoVM = new ApoderadoViewModel();
        $_apoderadoVM->id =$_nivel->MP_NIV_ID;
        $_apoderadoVM->nivel =$_nivel->MP_NIV_NIVEL;
        return $_apoderadoVM;
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
