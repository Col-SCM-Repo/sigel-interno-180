<?php
namespace App\Mappers;

use App\Helpers\EstadoMatricula;
use App\Matricula;
use App\ViewModel\MatriculaViewModel;
use Illuminate\Support\Facades\Auth;

class MatriculaMapper
{
    public function ModelToViewModel(Matricula $_matricula)
    {
        $_matriculaVM = new MatriculaViewModel();
        $_matriculaVM->id = $_matricula->MP_MAT_ID;
        $_matriculaVM->fecha_matricula = date('Y-m-d H:i:s',strtotime($_matricula->MP_MAT_FECHAMATRICULA));
        $_matriculaVM->pariente_id = $_matricula->MP_PAR_ID;
        $_matriculaVM->tipo_matricula_id = $_matricula->MP_TIPMAT_ID;
        $_matriculaVM->observacion = $_matricula->MP_MAT_OBS;
        $_matriculaVM->usuario_id = $_matricula->USU_ID;
        $_matriculaVM->institucion_educativa_procedencia_id = $_matricula->MP_IEPRO_ID;
        $_matriculaVM->estado = EstadoMatricula::ANumero($_matricula->MP_MAT_ESTADO) ;
        $_matriculaVM->alumno_id = $_matricula->MP_ALU_ID;
        $_matriculaVM->situacion = $_matricula->MP_MAT_SITUACION;
        $_matriculaVM->pago_observacion = $_matricula->MP_PAG_OBS;
        $_matriculaVM->vacante_id = $_matricula->MP_VAC_ID;
        $_matriculaVM->nivel = $_matricula->Vacante->Nivel->id();
        $_matriculaVM->grado = $_matricula->Vacante->Grado->id();
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
    public function ViewModel()
    {
        return new MatriculaViewModel();
    }
    public function ViewModelToModel($_matriculaVM)
    {
        $_matriculaM = new Matricula();
        if ($_matriculaVM->id!=0) {
            $_matriculaM->MP_MAT_ID = $_matriculaVM->id;
        }
        $_matriculaM->MP_MAT_FECHAMATRICULA = $_matriculaVM->fecha_matricula!=''?date('Y-m-d\TH:i:s',strtotime($_matriculaVM->fecha_matricula)):date('Y-m-d\TH:i:s');
        $_matriculaM->MP_PAR_ID =$_matriculaVM->pariente_id ;
        $_matriculaM->MP_TIPMAT_ID =$_matriculaVM->tipo_matricula_id;
        $_matriculaM->MP_MAT_OBS =$_matriculaVM->observacion ;
        $_matriculaM->USU_ID = $_matriculaVM->usuario_id!=''?$_matriculaVM->usuario_id:Auth::user()->id();
        $_matriculaM->MP_IEPRO_ID =$_matriculaVM->institucion_educativa_procedencia_id ;
        $_matriculaM->MP_MAT_ESTADO = EstadoMatricula::ALetras($_matriculaVM->estado);
        $_matriculaM->MP_ALU_ID =$_matriculaVM->alumno_id;
        $_matriculaM->MP_MAT_SITUACION =$_matriculaVM->situacion ;
        $_matriculaM->MP_PAG_OBS =$_matriculaVM->pago_observacion;
        $_matriculaM->MP_VAC_ID = $_matriculaVM->vacante_id ;
        $_matriculaM->MP_MAT_MONTOPENSION = $_matriculaVM->monto_pension==''?0: $_matriculaVM->monto_pension;
        return $_matriculaM;
    }
}
