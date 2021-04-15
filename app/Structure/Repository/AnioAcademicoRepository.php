<?php
namespace App\Structure\Repository;

use App\AnioAcademico;

class AnioAcademicoRepository extends AnioAcademico
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function ObtenerAnioVigente()
    {
        return $this::where("MP_ANIO_ESTADO","VIGENTE")->first();
    }
}
