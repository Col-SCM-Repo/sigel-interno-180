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
    public function Crear($alumno)
    {
        $nuevoAlumno = new Alumno();
        $nuevoAlumno = $alumno;
        $nuevoAlumno->save();
        return $nuevoAlumno->id();
    }
    public function Actualizar($alumno)
    {
        $actualizarAlumno = Alumno::find($alumno->id());
        $actualizarAlumno->MP_ALU_APELLIDOS = $alumno->MP_ALU_APELLIDOS;
        $actualizarAlumno->MP_ALU_NOMBRES = $alumno->MP_ALU_NOMBRES;
        $actualizarAlumno->MP_ALU_DNI = $alumno->MP_ALU_DNI;
        $actualizarAlumno->MP_ALU_DIRECCION =$alumno->MP_ALU_DIRECCION;
        $actualizarAlumno->MP_ALU_TELEFONO = $alumno->MP_ALU_TELEFONO;
        $actualizarAlumno->MP_ALU_CELULAR = $alumno->MP_ALU_CELULAR;
        $actualizarAlumno->MP_ALU_EMAIL = $alumno->MP_ALU_EMAIL;
        $actualizarAlumno->MP_ALU_SEXO = $alumno->MP_ALU_SEXO;
        $actualizarAlumno->MP_ALU_FECHANAC = $alumno->MP_ALU_FECHANAC;
        $actualizarAlumno->MP_PAIS_ID = $alumno->MP_PAIS_ID;
        $actualizarAlumno->MP_ALU_UBIGNAC = $alumno->MP_ALU_UBIGNAC;
        $actualizarAlumno->MP_REL_ID = $alumno->MP_REL_ID;
        $actualizarAlumno->MP_ALU_UBIGDIR = $alumno->MP_ALU_UBIGDIR;
        $actualizarAlumno->save();
        return $actualizarAlumno->id();
    }
}
