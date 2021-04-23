<?php
namespace App\Structure\Repository;

use App\Religion;

class ReligionRepository extends Religion
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function Crear($religionM)
    {
        $nuevaReligion = new Religion();
        $nuevaReligion = $religionM;
        $nuevaReligion->save();
        return $nuevaReligion->id();
    }
}
