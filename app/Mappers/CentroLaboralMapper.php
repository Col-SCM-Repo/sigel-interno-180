<?php
namespace App\Mappers;

use App\CentroLaboral;
use App\ViewModel\CentroLaboralViewModel;

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
    public function ViewModel()
    {
        return new CentroLaboralViewModel();
    }
    public function ViewModelToModel($_centroLaboralVM)
    {
        $_centroLaboralM = new CentroLaboral();
        if ($_centroLaboralVM->id!=0) {
            $_centroLaboralM->MP_CL_ID = $_centroLaboralVM->id;
        }
        $_centroLaboralM->MP_CL_NOMBRE = mb_strtoupper($_centroLaboralVM->nombre);
        return $_centroLaboralM;
    }
}
