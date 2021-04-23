<?php

namespace App\Http\Controllers;

use App\Religion;
use App\Structure\Services\ReligionService;
use Illuminate\Http\Request;

class ReligionesController extends Controller
{
    protected $_religionService;
    public function __construct(ReligionService $_religionService)
    {
        $this->_religionService=$_religionService;
    }
    public function ObtenerReligiones()
    {
        return $this->_religionService->ObtenerReligiones();
    }
    public function ObtenerModelo()
    {
        return response()->json($this->_religionService->CrearViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_religionService->Guardar($request->religion));
    }
}
