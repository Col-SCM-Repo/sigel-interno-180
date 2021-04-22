<?php
namespace App\Structure\Repository;

use App\TipoDocumento;

class TipoDocumentoRepository extends TipoDocumento
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
