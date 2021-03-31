<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Vacante;
use Illuminate\Http\Request;

class VacanteController extends Controller
{
    protected $ordernarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordernarArray = $ordenarArray;
    }
    public function Index()
    {
        return view('aulas.index');
    }
    public function ObtenerAulasPorAnio(Request $request)
    {
        $aulas=[];
        $aulas_aux = Vacante::where('MP_ANIO_ID', $request->anio_id)->get();
        foreach($aulas_aux as $aula_aux){
            $aula=[
                'id'=>$aula_aux->id(),
                'nombre_completo'=>$aula_aux->Nivel->nivel().' - '.$aula_aux->Grado->grado(). '° '. $aula_aux->Seccion->seccion(),
                'nivel'=>$aula_aux->Nivel->nivel(),
                'grado'=>$aula_aux->Grado->grado(),
                'seccion'=> $aula_aux->Seccion->seccion(),
            ];
            array_push($aulas, $aula);
        }
        return response()->json($this->ordernarArray->Ascendente($aulas,'nombre_completo'));
    }
}
