<?php
namespace App\Structure\Repository;

use App\InstitucionEducativa;

class InstitucionEducativaRepository extends InstitucionEducativa
{
    public function ObtenerTodas()
    {
        return $this::all();
    }
    public function Crear(InstitucionEducativa $_institucionEducativa)
    {
        $_nuevaInstitucionEducativa = New InstitucionEducativa();
        $_nuevaInstitucionEducativa = $_institucionEducativa;
        $_nuevaInstitucionEducativa->save();
        return $_nuevaInstitucionEducativa->id();
    }
}
