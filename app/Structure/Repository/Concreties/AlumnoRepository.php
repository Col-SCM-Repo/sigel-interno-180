<?php
namespace App\Structure\Repository\Concreties;

use App\Alumno;
use App\Structure\Repository\Abstracts\IAlumnoRepository;
class AlumnoRepository extends Alumno implements  IAlumnoRepository
{
    public function BuscarPorId($alumno_id)
    {
        return $this::find($alumno_id);
    }
    public function BuscarPorNombresApellidosDNI($texto)
    {
        return $this::where('MP_ALU_NOMBRES','like','%'.$texto.'%')->orWhere('MP_ALU_APELLIDOS','like','%'.$texto.'%')->orWhere('MP_ALU_DNI','like','%'.$texto.'%')->get();
    }
}
