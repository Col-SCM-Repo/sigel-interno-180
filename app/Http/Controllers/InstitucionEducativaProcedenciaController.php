<?php

namespace App\Http\Controllers;

use App\InstitucionEducativaProcedencia;
use Illuminate\Http\Request;

class InstitucionEducativaProcedenciaController extends Controller
{
    public function ObtenerInstituciones()
    {
        $instituciones =[];
        $aux = InstitucionEducativaProcedencia::all();
        foreach ($aux as $ie) {
            $institucion=[
                'id'=>$ie->id(),
                'nombre'=>$ie->nombre(),
                'referencia'=>$ie->referencia(),
            ];
            array_push($instituciones,$institucion);
        }
        return $instituciones;
    }
}
