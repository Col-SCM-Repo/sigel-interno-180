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
        $_matriculaVM->fecha_ingreso = $_matricula->MP_MAT_FECHAINGRESO? date('Y-m-d',strtotime($_matricula->MP_MAT_FECHAINGRESO)):'';
        $_matriculaVM->fecha_fin = $_matricula->MP_MAT_FECHAFIN? date('Y-m-d',strtotime($_matricula->MP_MAT_FECHAFIN)):'';
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
        $_matriculaVM->descuento_id = $_matricula->MP_DESCUENTO_ID;
        $_matriculaVM->puede_retirarse = EstadoMatricula::PueedeRetirarse($_matricula->Vacante->anioId());
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
        $_matriculaVM = new MatriculaViewModel();
        $_matriculaVM->fecha_ingreso = strtotime(date('Y-m-d'))< strtotime(date('Y-m-d',strtotime(date('Y').'-03-06')))?date('Y-m-d H:i:s',strtotime(date('Y').'03-06')):date('Y-m-d');
        return  $_matriculaVM;
    }
    public function ViewModelToModel($_matriculaVM)
    {
        $_matriculaM = new Matricula();
        if ($_matriculaVM->id!=0) {
            $_matriculaM->MP_MAT_ID = $_matriculaVM->id;
        }
        $_matriculaM->MP_MAT_FECHAMATRICULA = $_matriculaVM->fecha_matricula!=''?date('Y-m-d\TH:i:s',strtotime($_matriculaVM->fecha_matricula)):date('Y-m-d\TH:i:s');
        $_matriculaM->MP_MAT_FECHAINGRESO = $_matriculaVM->fecha_ingreso?date('Y-m-d\TH:i:s',strtotime($_matriculaVM->fecha_ingreso)):null;
        $_matriculaM->MP_MAT_FECHAFIN = $_matriculaVM->fecha_fin?date('Y-m-d\TH:i:s',strtotime($_matriculaVM->fecha_fin)):null;
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

        $_matriculaM->MP_DESCUENTO_ID = $_matriculaVM->descuento_id ;
        return $_matriculaM;
    }
}
