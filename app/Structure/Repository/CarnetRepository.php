<?php
namespace App\Structure\Repository;

use App\Carnet;

class CarnetRepository extends Carnet
{
    public function BuscarPorId($_carnetId)
    {
        return $this::find($_carnetId);
    }
    public function ObtenerPorAnio($_anioId)
    {
        return $this::where('anio_id', $_anioId)->get();
    }
    public function Crear($carnetM)
    {
        $nuevoCarnet = new Carnet();
        $nuevoCarnet->path =$carnetM->path;
        $nuevoCarnet->parte =$carnetM->parte;
        $nuevoCarnet->anio_id =$carnetM->anio_id;
        $nuevoCarnet->local_id =$carnetM->local_id;
        $nuevoCarnet->nivel_id =$carnetM->nivel_id;
        $nuevoCarnet->save();
        return $nuevoCarnet->id;
    }
    public function Actualizar($carnetM)
    {
        $actualizarCarnet = Carnet::find($carnetM->id());
        $actualizarCarnet->path =$carnetM->path;
        $actualizarCarnet->parte =$carnetM->parte;
        $actualizarCarnet->anio_id =$carnetM->anio_id;
        $actualizarCarnet->local_id =$carnetM->local_id;
        $actualizarCarnet->nivel_id =$carnetM->nivel_id;
        $actualizarCarnet->save();
        return $actualizarCarnet->id;
    }
}
