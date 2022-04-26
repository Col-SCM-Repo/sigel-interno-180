<?php
namespace App\Mappers;

use App\Carnet;
use App\ViewModel\CarnetViewModel;

class CarnetMapper
{
    public function ModelToViewModel(Carnet $_carnet)
    {
        $_carnetVM = new CarnetViewModel();
        $_carnetVM->id =$_carnet->id;
        $_carnetVM->path =$_carnet->path;
        $_carnetVM->parte =$_carnet->parte;
        $_carnetVM->anio_id =$_carnet->anio_id;
        $_carnetVM->anio =$_carnet->Anio();
        $_carnetVM->local_id =$_carnet->local_id;
        $_carnetVM->local =$_carnet->Local();
        $_carnetVM->nivel_id =$_carnet->nivel_id;
        $_carnetVM->nivel =$_carnet->Nivel();
        return $_carnetVM;
    }
    public function ListModelToViewModel($_carnets)
    {
        $_listCarnets = [];
        foreach ($_carnets as $carnet) {
            array_push($_listCarnets, self::ModelToViewModel($carnet));
        }
        return $_listCarnets;
    }
    public function ViewModel()
    {
        return new CarnetViewModel();
    }
    public function ViewModelToModel($_carnetVM)
    {
        $_carnetM = new Carnet();
        $_carnetM->id =$_carnetVM->id;
        $_carnetM->path =$_carnetVM->path;
        $_carnetM->parte =$_carnetVM->parte;
        $_carnetM->anio_id =$_carnetVM->anio_id;
        $_carnetM->local_id =$_carnetVM->local_id;
        $_carnetM->nivel_id =$_carnetVM->nivel_id;
        return $_carnetM;
    }
}
