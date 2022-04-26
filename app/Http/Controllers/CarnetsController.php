<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\CarnetService;
use Illuminate\Http\Request;

class CarnetsController extends Controller
{
    protected $ordenarArray;
    protected $_carnetService;
    public function __construct(OrdenarArray $ordenarArray,
                                CarnetService $_carnetService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_carnetService = $_carnetService;
    }
    public function ObtenerCarnetsPorAnio(Request $request)
    {
        return response()->json($this->_carnetService->ObtenerCarnetsPorAnio($request->anio_id));
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_carnetService->ObtenerModelo());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_carnetService->Guardar((object) $request->carnet));
    }
    public function GuardarImagen(Request $request)
    {
        $imagen = $request->file('carnet_foto');
        return response()->json($this->_carnetService->GuardarImagen($request->carnet_id, $imagen));
    }
}
