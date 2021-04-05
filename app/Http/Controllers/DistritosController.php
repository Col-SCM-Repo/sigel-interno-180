<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Helpers\OrdenarArray;
use Illuminate\Http\Request;

class DistritosController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray = $ordenarArray;
    }
    public function ObtenerDistritos()
    {
        $distritos=[];
        $aux = Distrito::all();
        foreach ($aux as $d) {
           $distrito = [
                'id'=>$d->id(),
                'region'=>$d->region(),
                'provincia'=>$d->provincia(),
                'distrito'=>$d->distrito(),
           ];
           array_push($distritos,$distrito);
        }
        return response()->json($this->ordenarArray->Ascendente($distritos,'region'));
    }
}
