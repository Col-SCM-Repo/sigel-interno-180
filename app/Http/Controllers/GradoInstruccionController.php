<?php

namespace App\Http\Controllers;

use App\GradoInstruccion;
use Illuminate\Http\Request;

class GradoInstruccionController extends Controller
{
    public function ObtenerGrados()
    {
        $grados =[];
        $aux = GradoInstruccion::all();
        foreach ($aux as $g) {
            $grado=[
                'id'=> $g->id(),
                'nombre'=> $g->nombre()
            ];
            array_push($grados,$grado);
        }
        return $grados;
    }
}
