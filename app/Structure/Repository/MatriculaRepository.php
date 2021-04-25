<?php
namespace App\Structure\Repository;

use App\Matricula;

class MatriculaRepository extends Matricula
{
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        return $this::where('MP_ALU_ID',$alumno_id)->orderBy('MP_MAT_ID','desc')->get();
    }
    public function ObtenerMatriculasPorVacanteId($vacante_id)
    {
        return $this::where('MP_VAC_ID',$vacante_id)->get();
    }
    public function ObtenerPorId($matricula_id)
    {
        return $this::find($matricula_id);
    }
    public function Crear($matriculaM)
    {
        $nuevaMatricula = new Matricula();
        $nuevaMatricula = $matriculaM;
        $nuevaMatricula->save();
        return $nuevaMatricula->id();
    }
    public function Actualizar($matriculaM)
    {
        $actualizarMatricula = Matricula::find($matriculaM->id());
        $actualizarMatricula->MP_MAT_FECHAMATRICULA = $matriculaM->MP_MAT_FECHAMATRICULA;
        $actualizarMatricula->MP_PAR_ID =$matriculaM->MP_PAR_ID ;
        $actualizarMatricula->MP_TIPMAT_ID =$matriculaM->MP_TIPMAT_ID;
        $actualizarMatricula->MP_MAT_OBS =$matriculaM->MP_MAT_OBS ;
        $actualizarMatricula->USU_ID = $matriculaM->USU_ID;
        $actualizarMatricula->MP_IEPRO_ID =$matriculaM->MP_IEPRO_ID ;
        $actualizarMatricula->MP_MAT_ESTADO = $matriculaM->MP_MAT_ESTADO;
        $actualizarMatricula->MP_ALU_ID =$matriculaM->MP_ALU_ID;
        $actualizarMatricula->MP_MAT_SITUACION =$matriculaM->MP_MAT_SITUACION ;
        $actualizarMatricula->MP_PAG_OBS =$matriculaM->MP_PAG_OBS;
        $actualizarMatricula->MP_VAC_ID = $matriculaM->MP_VAC_ID ;
        $actualizarMatricula->MP_MAT_MONTOPENSION = $matriculaM->MP_MAT_MONTOPENSION ;
        $actualizarMatricula->save();
        return $actualizarMatricula->id();
    }
}
