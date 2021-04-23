<?php
namespace App\Structure\Repository;

use App\CentroLaboral;

class CentroLaboralRepository extends CentroLaboral
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function Crear($centroLaboralM)
    {
        $nuevoCentroLaboral = new CentroLaboral();
        $nuevoCentroLaboral = $centroLaboralM;
        $nuevoCentroLaboral->save();
        return $nuevoCentroLaboral->id();
    }
}
