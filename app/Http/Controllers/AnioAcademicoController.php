<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\AnioAcademicoService;
use Illuminate\Http\Request;

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
    public function IndexVista()
    {
        return view('modulos.pagosMatriculas.anioAcademico.index');
    }
    public function ObtenerViewModel()
    {
        return response()->json($this->_anioAcademicoService->ObtenerViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_anioAcademicoService->Guardar((object) $request->anio));
    }
}
