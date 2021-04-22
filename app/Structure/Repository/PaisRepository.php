<?php
namespace App\Structure\Repository;

use App\Pais;

class PaisRepository extends Pais
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
