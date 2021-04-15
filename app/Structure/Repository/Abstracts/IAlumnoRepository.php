<?php
namespace App\Structure\Repository\Abstracts;

interface IAlumnoRepository
{
    public function BuscarPorId($alumno_id);

    public function BuscarPorNombresApellidosDNI($texto);
}
