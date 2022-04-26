<?php
namespace App\Structure\Repository;

use App\AnioAcademico;

class AnioAcademicoRepository extends AnioAcademico
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
    public function ObtenerAnioVigente()
    {
        return $this::where("MP_ANIO_ESTADO","VIGENTE")->first();
    }
    public function BuscarPorId($anio_id)
    {
        return $this::find($anio_id);
    }
    public function Crear($_anioM)
    {
        $nuevoAnio = new AnioAcademico();
        $nuevoAnio->MP_ANIO_FECHAINICIO = $_anioM->MP_ANIO_FECHAINICIO;
        $nuevoAnio->MP_ANIO_FECHAFIN =$_anioM->MP_ANIO_FECHAFIN;
        $nuevoAnio->MP_ANIO_DESCRIPCION =$_anioM->MP_ANIO_DESCRIPCION;
        $nuevoAnio->MP_ANIO_NOMBRE =$_anioM->MP_ANIO_NOMBRE;
        $nuevoAnio->MP_ANIO_ESTADO =$_anioM->MP_ANIO_ESTADO;
        $nuevoAnio->save();
        return $nuevoAnio->id();
    }
    public function Actualizar($_anioM)
    {
        $actualizarAnio = AnioAcademico::find($_anioM->id());
        $actualizarAnio->MP_ANIO_FECHAINICIO = $_anioM->MP_ANIO_FECHAINICIO;
        $actualizarAnio->MP_ANIO_FECHAFIN =$_anioM->MP_ANIO_FECHAFIN;
        $actualizarAnio->MP_ANIO_DESCRIPCION =$_anioM->MP_ANIO_DESCRIPCION;
        $actualizarAnio->MP_ANIO_NOMBRE =$_anioM->MP_ANIO_NOMBRE;
        $actualizarAnio->MP_ANIO_ESTADO =$_anioM->MP_ANIO_ESTADO;
        $actualizarAnio->save();
        return $actualizarAnio->id();
    }
}
