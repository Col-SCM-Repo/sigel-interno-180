<?php
namespace App\Mappers;

use App\TipoParentesco;
use App\ViewModel\TipoParentescoViewModel;

class TipoParentescoMapper
{
    public function ModelToViewModel(TipoParentesco $_tipoParentesco)
    {
        $_tipoParentescoVM = new TipoParentescoViewModel();
        $_tipoParentescoVM->id =$_tipoParentesco->MP_TIPAR_ID;
        $_tipoParentescoVM->nombre =$_tipoParentesco->MP_TIPAR_NOMBRE;
        return $_tipoParentescoVM;
    }
    public function ListModelToViewModel($_tiposParentesco)
    {
        $_listTiposParentesco = [];
        foreach ($_tiposParentesco as $tipo) {
            array_push($_listTiposParentesco, self::ModelToViewModel($tipo));
        }
        return $_listTiposParentesco;
    }
}
