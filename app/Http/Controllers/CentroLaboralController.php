<?php

namespace App\Http\Controllers;

use App\Structure\Services\CentroLaboralService;
use Illuminate\Http\Request;

class CentroLaboralController extends Controller
{
    protected $_centroLaboralService;
    public function __construct(CentroLaboralService $_centroLaboralService)
    {
        $this->_centroLaboralService = $_centroLaboralService;
    }
    public function ObtenerCentros()
    {
        return response()->json($this->_centroLaboralService->ObtenerCentrosLaboral());
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_centroLaboralService->CrearViewModel());
    }
    public function Guardar(Request $request)
    {
       return $this->_centroLaboralService->Guardar((object)$request->centro_laboral);
    }
}
