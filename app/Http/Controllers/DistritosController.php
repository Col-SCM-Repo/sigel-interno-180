<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\DistritoService;
use Illuminate\Http\Request;

class DistritosController extends Controller
{
    protected $ordenarArray;
    protected $_distritoService;
    public function __construct(OrdenarArray $ordenarArray,
                                DistritoService $_distritoService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_distritoService = $_distritoService;
    }
    public function ObtenerDistritos()
    {
        return response()->json($this->_distritoService->ObtenerDistritos());
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_distritoService->CrearViewModel());
    }
    public function Guardar(Request $request)
    {
       return $this->_distritoService->Guardar((object)$request->distrito);
    }
}
