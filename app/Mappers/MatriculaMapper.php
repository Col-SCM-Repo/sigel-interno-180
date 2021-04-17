<?php
namespace App\Mappers;

use App\Matricula;
use App\ViewModel\MatriculaViewModel;

class MatriculaMapper
{
    public function ModelToViewModel(Matricula $_matricula)
    {
        $_matriculaVM = new MatriculaViewModel();
        $_matriculaVM->id = $_matricula->MP_MAT_ID;
        $_matriculaVM->fecha_matricula = $_matricula->MP_MAT_FECHAMATRICULA;
        $_matriculaVM->pariente_id = $_matricula->MP_PAR_ID;
        $_matriculaVM->observacion = $_matricula->MP_MAT_OBS;
        $_matriculaVM->usuario_id = $_matricula->USU_ID;
        $_matriculaVM->institucion_educativa_procedencia_id = $_matricula->MP_IEPRO_ID;
        $_matriculaVM->estado = $_matricula->MP_MAT_ESTADO;
        $_matriculaVM->alumno_id = $_matricula->MP_ALU_ID;
        $_matriculaVM->pago_observacion = $_matricula->MP_PAG_OBS;
        $_matriculaVM->vacante_id = $_matricula->MP_VAC_ID;
        return $_matriculaVM;
    }
    public function ListModelToViewModel($_matriculas)
    {
        $_listMatriculas = [];
        foreach ($_matriculas as $matricula) {
            array_push($_listMatriculas, self::ModelToViewModel($matricula));
        }
        return $_listMatriculas;
    }
}
