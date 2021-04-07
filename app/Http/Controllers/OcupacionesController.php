<?php

namespace App\Http\Controllers;

use App\Ocupacion;
use Illuminate\Http\Request;

class OcupacionesController extends Controller
{
    public function ObtenerOcupaciones()
    {
        $ocupaciones =[];
        $aux = Ocupacion::all();
        foreach ($aux as $o) {
            $ocupacion=[
                'id'=> $o->id(),
                'nombre'=> $o->nombre()
            ];
            array_push($ocupaciones,$ocupacion);
        }
        return $ocupaciones;
    }
}
