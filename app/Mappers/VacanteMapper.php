<?php
namespace App\Mappers;

use App\Vacante;
use App\ViewModel\VacanteViewModel;

class VacanteMapper
{
    public function ModelToViewModel(Vacante $_vacante)
    {
        $_vacanteVM = new VacanteViewModel();
        $_vacanteVM->id =$_vacante->MP_VAC_ID;
        $_vacanteVM->total_vacantes =$_vacante->MP_ANIO_FECHAINICIO;
        $_vacanteVM->vacantes_ocupadas =$_vacante->MP_ANIO_FECHAFIN;
        $_vacanteVM->vacantes_disponibles =$_vacante->MP_ANIO_DESCRIPCION;
        $_vacanteVM->anio_id =$_vacante->MP_ANIO_ID;
        $_vacanteVM->grado_id =$_vacante->MP_GRAD_ID;
        $_vacanteVM->nivel_id =$_vacante->MP_NIV_ID;
        $_vacanteVM->seccion_id =$_vacante->MP_SEC_ID;
        return $_vacanteVM;
    }
    public function ListModelToViewModel($_vacantes)
    {
        $_listVacantes = [];
        foreach ($_vacantes as $vacante) {
            array_push($_listVacantes, self::ModelToViewModel($vacante));
        }
        return $_listVacantes;
    }
}
