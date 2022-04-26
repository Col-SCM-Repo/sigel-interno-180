<?php

namespace App\Http\Controllers;

use App\Structure\Services\SerieService;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    protected $_serieService;
    public function __construct(SerieService $_serieService)
    {
        $this->_serieService = $_serieService;
    }
    public function ObtenerViewModel()
    {
        return response()->json($this->_serieService->ObtenerViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_serieService->Guardar((object) $request->serie));
    }
}
