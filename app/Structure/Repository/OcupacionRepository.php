<?php
namespace App\Structure\Repository;

use App\Ocupacion;

class OcupacionRepository extends Ocupacion
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function Crear($ocupacionM)
    {
        $nuevaOcupacion = new Ocupacion();
        $nuevaOcupacion = $ocupacionM;
        $nuevaOcupacion->save();
        return $nuevaOcupacion->id();
    }
}
