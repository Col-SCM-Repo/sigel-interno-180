<?php
namespace App\Mappers;

use App\CronogramaPago;
use App\Helpers\CronogramaHelper;
use App\Matricula;
use App\Vacante;
use App\ViewModel\AlumnoMorosoViewModel;

class AlumnoMorosoMapper
{
    public function ModelsToViewModel(Matricula $_matriculaM, Vacante $_aulaM, CronogramaPago $_cronogramaM)
    {
        $_alumnoMorosoVM = new AlumnoMorosoViewModel();
        $_alumnoMorosoVM->id = $_matriculaM->Alumno->id();
        $_alumnoMorosoVM->apellidos = $_matriculaM->Alumno->apellidos();
        $_alumnoMorosoVM->nombres = $_matriculaM->Alumno->nombres();
        $_alumnoMorosoVM->matricula_id = $_matriculaM->id();
        $_alumnoMorosoVM->aula = $_aulaM->Grado->grado() . '° '.$_aulaM->Seccion->seccion();
        $_alumnoMorosoVM->nivel = $_aulaM->Nivel->nivel();
        $_alumnoMorosoVM->concepto = $_cronogramaM->ConceptoPago->Concepto->concepto();
        $_alumnoMorosoVM->saldo = CronogramaHelper::CalcularSaldo($_cronogramaM);
        $_alumnoMorosoVM->estado = $_cronogramaM->estado();
        $_alumnoMorosoVM->estado_matricula = $_matriculaM->estado();
        return $_alumnoMorosoVM;
    }

}
