<?php
namespace App\Structure\Repository;

use App\Vacante;

class VacanteRepository extends Vacante
{
    public function BuscarPorId($vacante_id)
    {
        return $this::find($vacante_id);
    }
}
