<?php
namespace App\Mappers;

use App\CentroLaboral;
use App\Pais;
use App\ViewModel\CentroLaboralViewModel;
use App\ViewModel\PaisViewModel;

class CentroLaboralMapper
{
    public function ModelToViewModel(CentroLaboral $_centroLaboral)
    {
        $_centroLaboralVM = new CentroLaboralViewModel();
        $_centroLaboralVM->id =$_centroLaboral->MP_CL_ID;
        $_centroLaboralVM->nombre =$_centroLaboral->MP_CL_NOMBRE;
        return $_centroLaboralVM;
    }
    public function ListModelToViewModel($_paises)
    {
        $_listPaises = [];
        foreach ($_paises as $pais) {
            array_push($_listPaises, self::ModelToViewModel($pais));
        }
        return $_listPaises;
    }
}
