<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\ConceptoPago;
use Illuminate\Http\Request;

class ConceptosController extends Controller
{
    public function ObtenerConceptosDelAnioActual()
    {
        $conceptos=[];
        $anio = AnioAcademico::where('MP_ANIO_ESTADO','VIGENTE')->first();
        $aux = ConceptoPago::where('MP_ANIO_ID', $anio->id());
        foreach ($aux as $c) {
           $concepto = [

           ];
           array_push($conceptos, $concepto);
        }
        return $conceptos;
    }
}
