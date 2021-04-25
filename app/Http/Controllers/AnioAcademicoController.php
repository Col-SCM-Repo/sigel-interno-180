<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\AnioAcademicoService;

class AnioAcademicoController extends Controller
{
    protected $ordenarArray;
    protected $_anioAcademicoService;
    public function __construct(OrdenarArray $ordenarArray,
                                AnioAcademicoService $_anioAcademicoService)
    {
        $this->ordenarArray=$ordenarArray;
        $this->_anioAcademicoService=$_anioAcademicoService;
    }
    public function ObtenerAnios()
    {
        return response()->json($this->ordenarArray->Descendete($this->_anioAcademicoService->ObtenerTodos(), 'nombre') );
    }
}
