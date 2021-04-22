<?php
namespace App\Structure\Repository;

use App\TipoParentesco;

class TipoParentescoRepository extends TipoParentesco
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
