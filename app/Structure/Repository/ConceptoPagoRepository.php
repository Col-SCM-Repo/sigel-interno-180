<?php
namespace App\Structure\Repository;

use App\ConceptoPago;

class ConceptoPagoRepository extends ConceptoPago
{
    public function BuscarPorAnioYNivel($anio_id,$nivel_id)
    {
        return $this::where('MP_ANIO_ID',$anio_id)->where('MP_NIV_ID',$nivel_id)->get();
    }
}
