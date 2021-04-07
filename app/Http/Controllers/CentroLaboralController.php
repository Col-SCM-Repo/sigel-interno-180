<?php

namespace App\Http\Controllers;

use App\CentroLaboral;
use Illuminate\Http\Request;

class CentroLaboralController extends Controller
{
    public function ObtenerCentros()
    {
        $centros =[];
        $aux = CentroLaboral::all();
        foreach ($aux as $c) {
            $centro=[
                'id'=> $c->id(),
                'nombre'=> $c->nombre()
            ];
            array_push($centros,$centro);
        }
        return $centros;
    }
}
