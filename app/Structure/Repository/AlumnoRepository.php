<?php
namespace App\Structure\Repository;

use App\Alumno;
class AlumnoRepository extends Alumno
{
    public function BuscarPorId($alumno_id)
    {
        return $this::find($alumno_id);
    }
    public function BuscarPorNombresApellidosDNI($texto)
    {
        return $this::where('MP_ALU_NOMBRES','like','%'.$texto.'%')->orWhere('MP_ALU_APELLIDOS','like','%'.$texto.'%')->orWhere('MP_ALU_DNI','like','%'.$texto.'%')->orderBy('MP_ALU_APELLIDOS')->get();
    }
    public function BuscarPorDNI($dni)
    {
        return $this::where('MP_ALU_DNI',$dni)->first();
    }
    public function BuscarPorId($alumno_id)
    {
        return $this::where('MP_ALU_DNI',$dni)->first();
    }
}
