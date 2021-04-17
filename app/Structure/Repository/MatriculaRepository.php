<?php
namespace App\Structure\Repository;

use App\Matricula;

class MatriculaRepository extends Matricula
{
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        return $this::where('MP_ALU_ID',$alumno_id)->orderBy('MP_MAT_ID','desc')->get();
    }
}
