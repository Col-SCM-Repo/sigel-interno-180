<?php
namespace App\Mappers;

use App\TipoIntitucionEducativa;
use App\TipoParentesco;
use App\ViewModel\TipoInstitucionEducativaViewModel;
use App\ViewModel\TipoParentescoViewModel;

class TipoInstitucionEducativaMapper
{
    public function ModelToViewModel(TipoIntitucionEducativa $_tipoInstitucionEducativa)
    {
        $_tipoInstitucionEducativaVM = new TipoInstitucionEducativaViewModel();
        $_tipoInstitucionEducativaVM->id =$_tipoInstitucionEducativa->MP_TIPOIEPRO_ID;
        $_tipoInstitucionEducativaVM->nombre =$_tipoInstitucionEducativa->MP_TIPOIEPRO_NOMBRE;
        $_tipoInstitucionEducativaVM->descripcion =$_tipoInstitucionEducativa->MP_TIPOIEPRO_DESCRIPCION;
        return $_tipoInstitucionEducativaVM;
    }
    public function ListModelToViewModel($_tiposInstitucionEducativa)
    {
        $_listTiposInstitucionEducativa = [];
        foreach ($_tiposInstitucionEducativa as $tipo) {
            array_push($_listTiposInstitucionEducativa, self::ModelToViewModel($tipo));
        }
        return $_listTiposInstitucionEducativa;
    }
}
