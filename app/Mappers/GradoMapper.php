<?php
namespace App\Mappers;

use App\Grado;
use App\ViewModel\GradoViewModel;

class GradoMapper
{
    public function ModelToViewModel(Grado $_grado)
    {
        $_gradoVM = new GradoViewModel();
        $_gradoVM->id =$_grado->MP_GRA_ID;
        $_gradoVM->grado =$_grado->MP_GRA_GRADO;
        return $_gradoVM;
    }
    public function ListModelToViewModel($_grados)
    {
        $_listGrados = [];
        foreach ($_grados as $grado) {
            array_push($_listGrados, self::ModelToViewModel($grado));
        }
        return $_listGrados;
    }
}
