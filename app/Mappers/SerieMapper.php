<?php
namespace App\Mappers;

use App\SerieComprobante;
use App\ViewModel\SerieViewModel;

class SerieMapper
{
    public function ModelToViewModel(SerieComprobante $_serieM)
    {
        $_serieVM = new SerieViewModel();
        $_serieVM->id =$_serieM->MP_SERCOM_ID;
        $_serieVM->nombre =$_serieM->MP_SERCOM_NOMBRE;
        $_serieVM->etiquetera_id =$_serieM->MP_ETI_ID;
        $_serieVM->usuario_id =$_serieM->USU_ID;
        return $_serieVM;
    }
    public function ListModelToViewModel($_series)
    {
        $_listaSeries = [];
        foreach ($_series as $serie) {
            array_push($_listaSeries, self::ModelToViewModel($serie));
        }
        return $_listaSeries;
    }
    public function ViewModel()
    {
        return new SerieViewModel();
    }

    public function ViewModelToModel($_serieVM)
    {
        $_serieM = new SerieComprobante();
        $_serieM->MP_SERCOM_ID =$_serieVM->id ;
        $_serieM->MP_SERCOM_NOMBRE =mb_strtoupper($_serieVM->nombre) ;
        $_serieM->MP_ETI_ID =$_serieVM->etiquetera_id ;
        $_serieM->USU_ID =$_serieVM->usuario_id ;
        return $_serieM ;
    }
}
