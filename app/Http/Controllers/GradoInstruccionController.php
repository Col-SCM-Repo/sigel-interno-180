<?php

namespace App\Http\Controllers;

use App\Structure\Services\GradoInstruccionService;
use Illuminate\Http\Request;

class GradoInstruccionController extends Controller
{
    protected $_gradoInstruccionService;
    public function __construct(GradoInstruccionService $_gradoInstruccionService)
    {
        $this->_gradoInstruccionService=$_gradoInstruccionService;
    }
    public function ObtenerGrados()
    {
        return $this->_gradoInstruccionService->ObtenerGradosInstruccion();
    }
}
