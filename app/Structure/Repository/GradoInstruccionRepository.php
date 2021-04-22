<?php
namespace App\Structure\Repository;

use App\GradoInstruccion;

class GradoInstruccionRepository extends GradoInstruccion
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
