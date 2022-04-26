<?php

namespace App\Http\Controllers;


class EmpleadosController extends Controller
{
    function ObtenerEmpleados()
    {
        $url ='http://sigelv2.test/api/obtener_empleados';
        $json = file_get_contents($url);
        $array = json_decode($json,true);
        dd($array);
        return $array;
    }
}
