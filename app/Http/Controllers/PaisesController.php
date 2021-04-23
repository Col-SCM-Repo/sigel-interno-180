<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Pais;
use App\Structure\Services\PaisService;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    protected $ordenarArray;
    protected $_paisService;
    public function __construct(OrdenarArray $ordenarArray,
                                PaisService $_paisService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_paisService = $_paisService;
    }
    public function ObtenerPaises()
    {
        return response()->json($this->_paisService->ObtenerPaises());
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_paisService->CrearViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_paisService->Guardar($request->pais));
    }
}
