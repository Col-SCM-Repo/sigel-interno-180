<?php
namespace App\Mappers;

use App\Religion;
use App\ViewModel\ReligionViewModel;

class ReligionMapper
{
    public function ModelToViewModel(Religion $_religion)
    {
        $_religionVM = new ReligionViewModel();
        $_religionVM->id =$_religion->MP_REL_ID;
        $_religionVM->religion =$_religion->MP_REL_NOMBRE;
        return $_religionVM;
    }
    public function ListModelToViewModel($_religiones)
    {
        $_listReligiones = [];
        foreach ($_religiones as $religion) {
            array_push($_listReligiones, self::ModelToViewModel($religion));
        }
        return $_listReligiones;
    }
    public function ViewModel()
    {
        return new ReligionViewModel();
    }
    public function ViewModelToModel($religion_nombre)
    {
        $_religionModel = new Religion();
        $_religionModel->MP_REL_NOMBRE = mb_strtoupper($religion_nombre);
        return $_religionModel;
    }
}
