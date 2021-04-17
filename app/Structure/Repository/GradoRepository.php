<?php
namespace App\Structure\Repository;

use App\Grado;

class GradoRepository extends Grado
{
    public function BuscarPorId($grado_id)
    {
        return $this::find($grado_id);
    }
}
