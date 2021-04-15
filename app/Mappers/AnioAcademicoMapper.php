<?php
namespace App\Mappers;

use App\AnioAcademico;
use App\ViewModel\AnioAcademicoViewModel;

class AnioAcademicoMapper
{
    public function ModelToViewModel(AnioAcademico $_anio)
    {
        $_anioVM = new AnioAcademicoViewModel();
        $_anioVM->id = $_anio->MP_ANIO_ID;
        $_anioVM->fecha_inicio = $_anio->MP_ANIO_FECHAINICIO;
        $_anioVM->fecha_fin = $_anio->MP_ANIO_FECHAFIN;
        $_anioVM->descripcion = $_anio->MP_ANIO_DESCRIPCION;
        $_anioVM->nombre = $_anio->MP_ANIO_NOMBRE;
        $_anioVM->estado = $_anio->MP_ANIO_ESTADO;
        return $_anioVM;
    }
    public function ListModelToViewModel($_anios)
    {
        $_listAnios = [];
        foreach ($_anios as $anio) {
            array_push($_listAnios, self::ModelToViewModel($anio));
        }
        return $_listAnios;
    }
}
