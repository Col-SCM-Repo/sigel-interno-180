<?php

namespace App\Http\Controllers;

use App\Apoderado;
use App\Parentesco;
use App\Structure\Services\ApoderadoService;
use App\Structure\Services\ParentescoService;
use Illuminate\Http\Request;

class ApoderadosController extends Controller
{
    protected $_parentescoService;
    protected $_apoderadoService;
    public function __construct(ParentescoService $_parentescoService,
                                ApoderadoService $_apoderadoService)
    {
        $this->_parentescoService= $_parentescoService;
        $this->_apoderadoService= $_apoderadoService;
    }
    public function ObtenerPorAlumno(Request $request)
    {
        return response()->json($this->_parentescoService->BuscarPorAlumnoId($request->alumno_id));
    }
    public function ModeloApoderado()
    {
        return response()->json($this->_apoderadoService->CrearViewModel());
    }
    public function GuardarApoderado(Request $request)
    {
        return $this->_apoderadoService->GuardarApoderado((object)$request->familiar);
    }
}
