<?php
namespace App\Structure\Repository;

use App\Nivel;

class NivelRepository extends Nivel
{
    public function BuscarPorId($nivel_id)
    {
        return $this::find($nivel_id);
    }
}
