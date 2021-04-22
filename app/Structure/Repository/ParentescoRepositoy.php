<?php
namespace App\Structure\Repository;

use App\Parentesco;

class ParentescoRepositoy extends Parentesco
{
    public function BuscarPorAlumnoId($alumno_id)
    {
        return $this::where('MP_ALU_ID',$alumno_id)->get();
    }
}
