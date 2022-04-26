<?php

namespace App\Http\Controllers;

use App\Structure\Services\ModuloNotas\NotaService;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    protected $notaService;
    public function __construct(NotaService $notaService)
    {
        $this->notaService = $notaService;
    }
    public function ObtenerNotasPorMatriculaTrimestre(Request $request)
    {
       return response()->json( $this->notaService->ObtenerCursosPorMatriculaTrimestre($request->matricula_id, $request->trimestre));
    }
}
