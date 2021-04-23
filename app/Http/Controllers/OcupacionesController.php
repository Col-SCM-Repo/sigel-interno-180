<?php

namespace App\Http\Controllers;

use App\Ocupacion;
use App\Structure\Services\OcupacionService;
use Illuminate\Http\Request;

class OcupacionesController extends Controller
{
    protected $_ocupacionService;
    public function __construct(OcupacionService $_ocupacionService)
    {
        $this->_ocupacionService = $_ocupacionService;
    }
    public function ObtenerOcupaciones()
    {
        return response()->json($this->_ocupacionService->ObtenerOcupaciones());
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_ocupacionService->CrearViewModel());
    }
    public function Guardar(Request $request)
    {
       return $this->_ocupacionService->Guardar((object)$request->ocupacion);
    }
}
