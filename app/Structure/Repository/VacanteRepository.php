<?php
namespace App\Structure\Repository;

use App\Vacante;

class VacanteRepository extends Vacante
{
    public function BuscarPorId($vacante_id)
    {
        return $this::find($vacante_id);
    }
    public function BuscarPorAnioId($anio_id)
    {
        return $this::where('MP_ANIO_ID', $anio_id)->get();
    }
    public function BuscarPorAnioNivelGrado($anio_id,$nivel_id,$grado_id)
    {
        return $this::where('MP_ANIO_ID',$anio_id)->where('MP_NIV_ID',$nivel_id)->where('MP_GRAD_ID',$grado_id)->get();
    }
    public function BuscarAulasPorAnioNivel($anio_id,$nivel_id)
    {
        return $this::where('MP_ANIO_ID', $anio_id)->where('MP_NIV_ID', $nivel_id)->orderBy('MP_GRAD_ID')->orderBy('MP_SEC_ID')->get();;
    }
    public function Crear($_vacanteM)
    {
        $nuevaVacante = new Vacante();
        $nuevaVacante->MP_VAC_TOT =$_vacanteM->MP_VAC_TOT ;
        $nuevaVacante->MP_ANIO_ID =$_vacanteM->MP_ANIO_ID ;
        $nuevaVacante->MP_GRAD_ID =$_vacanteM->MP_GRAD_ID ;
        $nuevaVacante->MP_NIV_ID =$_vacanteM->MP_NIV_ID ;
        $nuevaVacante->MP_SEC_ID =$_vacanteM->MP_SEC_ID ;
        $nuevaVacante->MP_LOC_ID =$_vacanteM->MP_LOC_ID ;
        $nuevaVacante->MP_VAC_OBS =$_vacanteM->MP_VAC_OBS ;
        $nuevaVacante->save();
        return $nuevaVacante->id();
    }
    public function Actualizar($_vacanteM)
    {
        $actualizarVacante = Vacante::find($_vacanteM->id());
        $actualizarVacante->MP_VAC_TOT =$_vacanteM->MP_VAC_TOT ;
        $actualizarVacante->MP_ANIO_ID =$_vacanteM->MP_ANIO_ID ;
        $actualizarVacante->MP_GRAD_ID =$_vacanteM->MP_GRAD_ID ;
        $actualizarVacante->MP_NIV_ID =$_vacanteM->MP_NIV_ID ;
        $actualizarVacante->MP_SEC_ID =$_vacanteM->MP_SEC_ID ;
        $actualizarVacante->MP_LOC_ID =$_vacanteM->MP_LOC_ID ;
        $actualizarVacante->MP_VAC_OBS =$_vacanteM->MP_VAC_OBS ;
        $actualizarVacante->save();
        return $actualizarVacante->id();
    }
}
