<?php
namespace App\Mappers;

use App\Distrito;
use App\ViewModel\DistritoViewModel;

class DistritoMapper
{
    public function ModelToViewModel(Distrito $_distrito)
    {
        $_distritoVM = new DistritoViewModel();
        $_distritoVM->id =$_distrito->MP_UBIG_ID;
        $_distritoVM->region =$_distrito->MP_UBIG_REGION;
        $_distritoVM->provincia =$_distrito->MP_UBIG_PROVINCIA;
        $_distritoVM->distrito =$_distrito->MP_UBIG_DISTRITO;
        return $_distritoVM;
    }
    public function ListModelToViewModel($_distritos)
    {
        $_listDistritos = [];
        foreach ($_distritos as $distrito) {
            array_push($_listDistritos, self::ModelToViewModel($distrito));
        }
        return $_listDistritos;
    }
}
