<?php
namespace App\Structure\Repository;

use App\Apoderado;

class ApoderadoRepositoy extends Apoderado
{
    public function Actualizar($apoderadoM)
    {
        $actualizarApoderado = Apoderado::find($apoderadoM->id());
        $actualizarApoderado->MP_APO_NOMBRES = $apoderadoM->MP_APO_NOMBRES ;
        $actualizarApoderado->MP_APO_APELLIDOS = $apoderadoM->MP_APO_APELLIDOS ;
        $actualizarApoderado->MP_APO_NRODOC = $apoderadoM->MP_APO_NRODOC ;
        $actualizarApoderado->MP_APO_DIRECCION = $apoderadoM->MP_APO_DIRECCION ;
        $actualizarApoderado->MP_APO_CELULAR = $apoderadoM->MP_APO_CELULAR ;
        $actualizarApoderado->MP_APO_TELEFONO = $apoderadoM->MP_APO_TELEFONO ;
        $actualizarApoderado->MP_APO_EMAIL = $apoderadoM->MP_APO_EMAIL ;
        $actualizarApoderado->MP_APO_FECHANAC = $apoderadoM->MP_APO_FECHANAC;
        $actualizarApoderado->MP_APO_SEXO = $apoderadoM->MP_APO_SEXO ;
        $actualizarApoderado->MP_APO_VIVE = $apoderadoM->MP_APO_VIVE ;
        $actualizarApoderado->MP_EC_ID = $apoderadoM->MP_EC_ID ;
        $actualizarApoderado->MP_REL_ID = $apoderadoM->MP_REL_ID ;
        $actualizarApoderado->MP_PAIS_ID = $apoderadoM->MP_PAIS_ID;
        $actualizarApoderado->MP_PAIS_DIR_ID = $apoderadoM->MP_PAIS_DIR_ID ;
        $actualizarApoderado->MP_APO_UBIGNAC = $apoderadoM->MP_APO_UBIGNAC;
        $actualizarApoderado->MP_APO_UBIGDIR = $apoderadoM->MP_APO_UBIGDIR;
        $actualizarApoderado->MP_CL_ID = $apoderadoM->MP_CL_ID;
        $actualizarApoderado->MP_OCU_ID = $apoderadoM->MP_OCU_ID;
        $actualizarApoderado->MP_GI_ID= $apoderadoM->MP_GI_ID;
        $actualizarApoderado->MP_TIPDOC_ID = $apoderadoM->MP_TIPDOC_ID;
        $actualizarApoderado->save();
        return $actualizarApoderado->id();
    }
    public function Crear($apoderadoM)
    {
        $nuevoApoderado = new Apoderado();
        $nuevoApoderado = $apoderadoM;
        $nuevoApoderado->save();
        return $nuevoApoderado->id();
    }
}
