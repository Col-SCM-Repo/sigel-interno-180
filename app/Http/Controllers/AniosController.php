<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\Helpers\OrdenarArray;
use Illuminate\Http\Request;

class AniosController extends Controller
{
    private $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray = $ordenarArray;
    }
    public function ObtenerAnios()
    {
        $anios=[];
        $anios_aux = AnioAcademico::all();
        foreach ($anios_aux as $anio_aux) {
            $anio =[
                'id'=>$anio_aux->id(),
                'nombre'=>$anio_aux->nombre()
            ];
            array_push($anios,$anio);
        }
        return response()->json($this->ordenarArray->Descendete($anios,'nombre'));
    }
}
