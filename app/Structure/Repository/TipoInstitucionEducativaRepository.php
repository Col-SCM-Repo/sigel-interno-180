<?php
namespace App\Structure\Repository;

use App\TipoIntitucionEducativa;

class TipoInstitucionEducativaRepository extends TipoIntitucionEducativa
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function BuscarPorId($tipo_id)
    {
        return $this::find($tipo_id);
    }
}
