<?php
namespace App\Structure\Repository;

use App\NotaAcademica;

class NotaRepository extends NotaAcademica
{
    public function ObtenerPorMatriculaTrimestre($matriculaId, $trimest)
    {
        return $this::where('matricula_id',$matriculaId )->where('periodo_id', $trimest)->get();
    }
}
