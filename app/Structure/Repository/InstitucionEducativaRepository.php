<?php
namespace App\Structure\Repository;

use App\InstitucionEducativa;

class InstitucionEducativaRepository extends InstitucionEducativa
{
    public function ObtenerTodas()
    {
        return $this::all();
    }
}
