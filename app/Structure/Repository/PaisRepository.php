<?php
namespace App\Structure\Repository;

use App\Pais;

class PaisRepository extends Pais
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function Crear($paisM)
    {
        $nuevoPais = new Pais();
        $nuevoPais = $paisM;
        $nuevoPais->save();
        return $nuevoPais->id();
    }
}
