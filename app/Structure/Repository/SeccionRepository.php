<?php
namespace App\Structure\Repository;

use App\Seccion;

class SeccionRepository extends Seccion
{
    public function BuscarPorId($seccion_id)
    {
        return $this::find($seccion_id);
    }
}
