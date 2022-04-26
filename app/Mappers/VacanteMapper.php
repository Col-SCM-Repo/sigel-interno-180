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
        $_vacanteVM->nombre_completo =$_vacante->Nivel->nivel().' - '.$_vacante->Grado->grado(). '° '. $_vacante->Seccion->seccion();
        $_vacanteVM->total_vacantes =$_vacante->MP_VAC_TOT;
        $_vacanteVM->vacantes_ocupadas =count($_vacante->Matriculas->where('MP_MAT_ESTADO','!=','RETIRADO'));
        $_vacanteVM->vacantes_disponibles =$_vacanteVM->total_vacantes-$_vacanteVM->vacantes_ocupadas;
        $_vacanteVM->anio_id =$_vacante->MP_ANIO_ID;
        $_vacanteVM->grado_id =$_vacante->MP_GRAD_ID;
        $_vacanteVM->nivel_id =$_vacante->MP_NIV_ID;
        $_vacanteVM->seccion_id =$_vacante->MP_SEC_ID;
        $_vacanteVM->local_id =$_vacante->MP_LOC_ID;
        $_vacanteVM->observacion =$_vacante->MP_VAC_OBS;
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
    public function ViewModel()
    {
        return new VacanteViewModel();
    }
    public function ViewModelToModel($_vacanteVM)
    {
        $_vacanteModel = new Vacante();
        $_vacanteModel->MP_VAC_ID =$_vacanteVM->id ;
        $_vacanteModel->MP_VAC_TOT =$_vacanteVM->total_vacantes ;
        $_vacanteModel->MP_ANIO_ID =$_vacanteVM->anio_id ;
        $_vacanteModel->MP_GRAD_ID =$_vacanteVM->grado_id ;
        $_vacanteModel->MP_NIV_ID =$_vacanteVM->nivel_id ;
        $_vacanteModel->MP_SEC_ID =$_vacanteVM->seccion_id ;
        $_vacanteModel->MP_LOC_ID =$_vacanteVM->local_id ;
        $_vacanteModel->MP_VAC_OBS =isset($_vacanteVM->observacion)?$_vacanteVM->observacion:'' ;
        return $_vacanteModel;
    }
}
