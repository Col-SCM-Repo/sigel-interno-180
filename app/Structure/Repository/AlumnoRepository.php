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
    public function Crear($alumnoM)
    {
        $nuevoAlumno = new Alumno();
        $nuevoAlumno = $alumnoM;
        $nuevoAlumno->save();
        return $nuevoAlumno->id();
    }
    public function Actualizar($alumnoM)
    {
        $actualizarAlumno = Alumno::find($alumnoM->id());
        $actualizarAlumno->MP_ALU_APELLIDOS = $alumnoM->MP_ALU_APELLIDOS;
        $actualizarAlumno->MP_ALU_NOMBRES = $alumnoM->MP_ALU_NOMBRES;
        $actualizarAlumno->MP_ALU_DNI = $alumnoM->MP_ALU_DNI;
        $actualizarAlumno->MP_ALU_DIRECCION =$alumnoM->MP_ALU_DIRECCION;
        $actualizarAlumno->MP_ALU_TELEFONO = $alumnoM->MP_ALU_TELEFONO;
        $actualizarAlumno->MP_ALU_CELULAR = $alumnoM->MP_ALU_CELULAR;
        $actualizarAlumno->MP_ALU_EMAIL = $alumnoM->MP_ALU_EMAIL;
        $actualizarAlumno->MP_ALU_SEXO = $alumnoM->MP_ALU_SEXO;
        $actualizarAlumno->MP_ALU_FECHANAC = $alumnoM->MP_ALU_FECHANAC;
        $actualizarAlumno->MP_PAIS_ID = $alumnoM->MP_PAIS_ID;
        $actualizarAlumno->MP_ALU_UBIGNAC = $alumnoM->MP_ALU_UBIGNAC;
        $actualizarAlumno->MP_REL_ID = $alumnoM->MP_REL_ID;
        $actualizarAlumno->MP_ALU_UBIGDIR = $alumnoM->MP_ALU_UBIGDIR;
        $actualizarAlumno->save();
        return $actualizarAlumno->id();
    }
}
