<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Pais;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray = $ordenarArray;
    }
    public function ObtenerPaises()
    {
        $paises=[];
        $aux = Pais::all();
        foreach ($aux as $p) {
           $pais = [
                'id'=>$p->id(),
                'nombre'=>$p->nombre(),
           ];
           array_push($paises,$pais);
        }
        return response()->json($this->ordenarArray->Ascendente($paises,'nombre'));
    }
}
