<?php

namespace App\Http\Controllers;

use App\TipoParentesco;
use Illuminate\Http\Request;

class TipoParentescoController extends Controller
{
    public function ObtenerTipos()
    {
        $tipos=[];
        $aux = TipoParentesco::all();
        foreach ($aux as $t) {
            $tipo = [
                'id'=> $t->id(),
                'nombre'=> $t->nombre()
            ];
            array_push($tipos,$tipo);
        }
        return $tipos;
    }
}
