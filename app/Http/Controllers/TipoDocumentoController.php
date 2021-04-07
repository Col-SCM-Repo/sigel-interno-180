<?php

namespace App\Http\Controllers;

use App\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function ObtenerTipos()
    {
        $tipos =[];
        $aux = TipoDocumento::all();
        foreach ($aux as $t) {
            $tipo=[
                'id'=> $t->id(),
                'nombre'=> $t->nombre()
            ];
            array_push($tipos,$tipo);
        }
        return $tipos;
    }
}
