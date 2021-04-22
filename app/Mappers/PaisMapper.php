<?php
namespace App\Mappers;

use App\Pais;
use App\ViewModel\PaisViewModel;

class PaisMapper
{
    public function ModelToViewModel(Pais $_pais)
    {
        $_paisVM = new PaisViewModel();
        $_paisVM->id =$_pais->MP_PAIS_ID;
        $_paisVM->pais =$_pais->MP_PAIS_NOMBRE;
        return $_paisVM;
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
