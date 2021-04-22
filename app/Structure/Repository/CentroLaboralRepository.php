<?php
namespace App\Structure\Repository;

use App\CentroLaboral;

class CentroLaboralRepository extends CentroLaboral
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
