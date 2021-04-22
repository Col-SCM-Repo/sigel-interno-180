<?php
namespace App\Structure\Repository;

use App\Ocupacion;

class OcupacionRepository extends Ocupacion
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
