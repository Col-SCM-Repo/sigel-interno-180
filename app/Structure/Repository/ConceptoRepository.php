<?php
namespace App\Structure\Repository;

use App\Concepto;

class ConceptoRepository extends Concepto
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
