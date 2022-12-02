<?php
namespace App\Mappers;

use App\ModuloSistema;
use App\ViewModel\ModuloSistemaViewModel;

class ModuloSistemaMapper
{
    public function ModelToViewModel( $_moduloSistemaM)
    {
        if(!$_moduloSistemaM) return null;
        $_moduloSistemaVM = new ModuloSistemaViewModel();

        $_moduloSistemaVM->id = $_moduloSistemaM->MP_MODULOS_SISTEMA_ID;
        $_moduloSistemaVM->nombre_modulo = $_moduloSistemaM->MP_NOMBRE_MODULO;
        $_moduloSistemaVM->nombre_submodulo = $_moduloSistemaM->MP_NOMBRE_SUBMODULO;
        $_moduloSistemaVM->observaciones = $_moduloSistemaM->MP_OBSERVACIONES;
        return $_moduloSistemaVM;
    }
    public function ListModelToViewModel($_moduloSistemasM)
    {
        $_listModulosSistemasVM = [];
        foreach ($_moduloSistemasM as $_moduloSistemaM) {
            array_push($_listModulosSistemasVM, self::ModelToViewModel($_moduloSistemaM));
        }
        return $_listModulosSistemasVM;
    }
    public function ViewModel()
    {
        return new ModuloSistemaViewModel();
    }
    public function ViewModelToModel($_moduloSistemaVM)
    {
        if(!$_moduloSistemaVM) return null;
        $_moduloSistemaModel = new ModuloSistema();
        $_moduloSistemaModel->MP_MODULOS_SISTEMA_ID = $_moduloSistemaVM->id;
        $_moduloSistemaModel->MP_NOMBRE_MODULO = $_moduloSistemaVM->nombre_modulo;
        $_moduloSistemaModel->MP_NOMBRE_SUBMODULO = $_moduloSistemaVM->nombre_submodulo;
        $_moduloSistemaModel->MP_OBSERVACIONES = $_moduloSistemaVM->observaciones;
        return $_moduloSistemaModel;
    }
}
