<?php
namespace App\Mappers\ModuloNotas;

use App\Matricula;
use App\ViewModel\ModuloNotas\AlumnoViewModel;

class AlumnoMapper
{
    public function ModelToViewModel(Matricula $_matricula)
    {
        $_alumnoViewModel = new AlumnoViewModel();
        $_alumnoViewModel->id = $_matricula->MP_ALU_ID;
        $_alumnoViewModel->apellidos = $_matricula->Alumno->MP_ALU_APELLIDOS;
        $_alumnoViewModel->nombres = $_matricula->Alumno->MP_ALU_NOMBRES;
        $_alumnoViewModel->matricula_id = $_matricula->id();
        $_alumnoViewModel->aula = $_matricula->Vacante->Grado->grado() . '° '. $_matricula->Vacante->Seccion->seccion();
        $_alumnoViewModel->nivel = $_matricula->Vacante->Nivel->nivel();
        $_alumnoViewModel->anio = $_matricula->Vacante->AnioAcademico->nombre();
        return $_alumnoViewModel;
    }
    public function ListModelToViewModel($_matriculas)
    {
        $_listAlumnos = [];
        foreach ($_matriculas as $matricula) {
            array_push($_listAlumnos, self::ModelToViewModel($matricula));
        }
        return $_listAlumnos;
    }
}
