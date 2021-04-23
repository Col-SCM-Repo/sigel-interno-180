<?php
namespace App\Structure\Repository;

use App\Distrito;

class DistritoRepository extends Distrito
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function Crear($distritoM)
    {
        $nuevoDistrito = new Distrito();
        $nuevoDistrito = $distritoM;
        $nuevoDistrito->save();
        return $nuevoDistrito->id();
    }
}
