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
    public function ViewModel()
    {
        return new InstitucionEducativaViewModel();
    }
    public function ViewModelToModel($_institucionVM)
    {
        $_institucionM = new InstitucionEducativa();
        if ($_institucionVM->id!=0) {
            $_institucionM->MP_IEPRO_ID = $_institucionVM->id;
        }
        $_institucionM->MP_IEPRO_NOMBRE = mb_strtoupper($_institucionVM->nombre);
        $_institucionM->MP_IEPRO_REFERENCIA = mb_strtoupper($_institucionVM->referencia);
        $_institucionM->MP_IEPRO_CODMODULAR = mb_strtoupper($_institucionVM->codigo_modular);
        $_institucionM->MP_IEPRO_DIRECCION = mb_strtoupper($_institucionVM->direccion);
        $_institucionM->MP_TIPOIEPRO_ID = $_institucionVM->tipo_ie_id;
        $_institucionM->MP_IECON_ID = $_institucionVM->condicion_ie_id;
        $_institucionM->MP_UBIG_ID = $_institucionVM->distrito_id;
        $_institucionM->MP_PAIS_ID = $_institucionVM->pais_id;
        return $_institucionM;
    }
}
