<?php
namespace App\Structure\Repository;

use App\TipoParentesco;

class TipoParentescoRepository extends TipoParentesco
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function BuscarPorId($tipo_parentesco_id)
    {
        return $this::find($tipo_parentesco_id);
    }
}
