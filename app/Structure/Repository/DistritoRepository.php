<?php
namespace App\Structure\Repository;

use App\Distrito;

class DistritoRepository extends Distrito
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
