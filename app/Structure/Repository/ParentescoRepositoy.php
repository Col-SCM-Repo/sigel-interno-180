<?php
namespace App\Structure\Repository;

use App\Parentesco;
use App\Seccion;

class ParentescoRepositoy extends Parentesco
{
    public function BuscarPorId($parentesco_id)
    {
        return $this::find($parentesco_id);
    }
}
