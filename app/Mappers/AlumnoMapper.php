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
        $_alumnoViewModel->fecha_nacimiento = date('Y-m-d',strtotime($_alumno->MP_ALU_FECHANAC));
        $_alumnoViewModel->pais_id = $_alumno->MP_PAIS_ID;
        $_alumnoViewModel->distrito_nacimiento = $_alumno->MP_ALU_UBIGNAC;
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
    public function ViewModel()
    {
        return new AlumnoViewModel();
    }

    public function ViewModelToModel($_alumnoViewModel)
    {
        $_alumnoModel = new Alumno();
        $_alumnoModel->MP_ALU_ID = $_alumnoViewModel->id == 0? null:$_alumnoViewModel->id;
        $_alumnoModel->MP_ALU_APELLIDOS = mb_strtoupper($_alumnoViewModel->apellidos);
        $_alumnoModel->MP_ALU_NOMBRES = mb_strtoupper($_alumnoViewModel->nombres);
        $_alumnoModel->MP_ALU_DNI = $_alumnoViewModel->dni;
        $_alumnoModel->MP_ALU_DIRECCION = mb_strtoupper($_alumnoViewModel->direccion);
        $_alumnoModel->MP_ALU_TELEFONO = $_alumnoViewModel->telefono;
        $_alumnoModel->MP_ALU_CELULAR = $_alumnoViewModel->celular;
        $_alumnoModel->MP_ALU_EMAIL = $_alumnoViewModel->correo;
        $_alumnoModel->MP_ALU_SEXO = $_alumnoViewModel->genero;
        $_alumnoModel->MP_ALU_FECHANAC = date('Y-m-d H:i:s',strtotime($_alumnoViewModel->fecha_nacimiento));
        $_alumnoModel->MP_PAIS_ID = $_alumnoViewModel->pais_id;
        $_alumnoModel->MP_ALU_UBIGNAC = $_alumnoViewModel->distrito_nacimiento;
        $_alumnoModel->MP_REL_ID = $_alumnoViewModel->religion_id;
        $_alumnoModel->MP_ALU_UBIGDIR = $_alumnoViewModel->distrito_residencia;
        return $_alumnoModel;
    }
}
