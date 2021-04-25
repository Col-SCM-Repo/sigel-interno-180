<?php
namespace App\Mappers;

use App\InstitucionEducativa;
use App\ViewModel\InstitucionEducativaViewModel;

class InstitucionEducativaMapper
{
    public function ModelToViewModel(InstitucionEducativa $_institucionEducativa)
    {
        $_institucionEducativaVM = new InstitucionEducativaViewModel();
        $_institucionEducativaVM->id =$_institucionEducativa->MP_IEPRO_ID;
        $_institucionEducativaVM->nombre =$_institucionEducativa->MP_IEPRO_NOMBRE;
        $_institucionEducativaVM->referencia =$_institucionEducativa->MP_IEPRO_REFERENCIA;
        return $_institucionEducativaVM;
    }
    public function ListModelToViewModel($_instituciones)
    {
        $_listInstituciones = [];
        foreach ($_instituciones as $institucion) {
            array_push($_listInstituciones, self::ModelToViewModel($institucion));
        }
        return $_listInstituciones;
    }
}
