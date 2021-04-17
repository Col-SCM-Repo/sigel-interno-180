<?php
namespace App\Mappers;

use App\Seccion;
use App\ViewModel\SeccionViewModel;

class SeccionMapper
{
    public function ModelToViewModel(Seccion $_seccion)
    {
        $_seccionVM = new SeccionViewModel();
        $_seccionVM->id =$_seccion->MP_SEC_ID;
        $_seccionVM->seccion =$_seccion->MP_SEC_NOMBRE;
        return $_seccionVM;
    }
    public function ListModelToViewModel($_secciones)
    {
        $_listSecciones = [];
        foreach ($_secciones as $seccion) {
            array_push($_listSecciones, self::ModelToViewModel($seccion));
        }
        return $_listSecciones;
    }
}
