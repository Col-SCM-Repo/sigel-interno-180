<?php
namespace App\Structure\Repository;

use App\SerieComprobante;

class SerieRepository extends SerieComprobante
{
    public function BuscarPorUsuario($_usuarioId)
    {
        return $this::where('USU_ID',$_usuarioId)->get()->last();
    }
    public function Crear($_serieM)
    {
        $nuevaSerie = new SerieComprobante();
        $nuevaSerie->MP_SERCOM_NOMBRE =$_serieM->MP_SERCOM_NOMBRE ;
        $nuevaSerie->MP_ETI_ID =$_serieM->MP_ETI_ID ;
        $nuevaSerie->USU_ID =$_serieM->USU_ID ;
        $nuevaSerie->save();
        return $nuevaSerie->id();
    }
    public function Actualizar($_serieM)
    {
        $actualizarSerie = SerieComprobante::find($_serieM->id());
        $actualizarSerie->MP_SERCOM_NOMBRE =$_serieM->MP_SERCOM_NOMBRE ;
        $actualizarSerie->MP_ETI_ID =$_serieM->MP_ETI_ID ;
        $actualizarSerie->USU_ID =$_serieM->USU_ID ;
        $actualizarSerie->save();
        return $actualizarSerie->id();
    }
}
