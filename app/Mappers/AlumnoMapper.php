<?php
namespace App\Mappers;

use App\Alumno;
use App\ViewModel\AlumnoViewModel;

class AlumnoMapper
{
    public function ModelToViewModel(Alumno $_alumno)
    {
        $_alumnoViewModel = new AlumnoViewModel();
        $_alumnoViewModel->id = $_alumno->MP_ALU_ID;
        $_alumnoViewModel->apellidos = $_alumno->MP_ALU_APELLIDOS;
        $_alumnoViewModel->nombres = $_alumno->MP_ALU_NOMBRES;
        $_alumnoViewModel->dni = $_alumno->MP_ALU_DNI;
        $_alumnoViewModel->direccion = $_alumno->MP_ALU_DIRECCION;
        $_alumnoViewModel->telefono = $_alumno->MP_ALU_TELEFONO;
        $_alumnoViewModel->celular = $_alumno->MP_ALU_CELULAR;
        $_alumnoViewModel->correo = $_alumno->MP_ALU_EMAIL;
        $_alumnoViewModel->genero = $_alumno->MP_ALU_SEXO;
        $_alumnoViewModel->fecha_nacimiento = date('d-m-Y',strtotime($_alumno->MP_ALU_FECHANAC));
        $_alumnoViewModel->pais_id = $_alumno->MP_PAIS_ID;
        $_alumnoViewModel->distrito_nacimineto = $_alumno->MP_ALU_UBIGNAC;
        $_alumnoViewModel->religion_id = $_alumno->MP_REL_ID;
        $_alumnoViewModel->distrito_residencia = $_alumno->MP_ALU_UBIGDIR;
        return $_alumnoViewModel;
    }
    public function ListModelToViewModel($_alumnos)
    {
        $_listAlumnos = [];
        foreach ($_alumnos as $alumno) {
            array_push($_listAlumnos, self::ModelToViewModel($alumno));
        }
        return $_listAlumnos;
    }
}
