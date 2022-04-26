<?php

namespace App\Http\Controllers;

use App\Helpers\EstadoMatricula;
use App\Structure\Services\AlumnoService;
use App\Structure\Services\CronogramaService;
use App\Structure\Services\MatriculaService;
use App\Structure\Services\VacanteService;
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    protected $_cronogramaService;
    protected $_matriculaService;
    protected $_alumnoService;
    protected $_vacanteService;
    public function __construct(CronogramaService $_cronogramaService,
                                MatriculaService $_matriculaService,
                                AlumnoService $_alumnoService,
                                VacanteService $_vacanteService)
    {
        $this->_cronogramaService =  $_cronogramaService;
        $this->_matriculaService =  $_matriculaService;
        $this->_alumnoService =  $_alumnoService;
        $this->_vacanteService =  $_vacanteService;
    }
    public function Index($matricula_id)
    {
        return view('modulos.pagosMatriculas.cronograma.index')->with('matricula_id', $matricula_id);
    }

    public function ObtenerCronogramasPorMatricula(Request $request)
    {
        $matriculaVM = $this->_matriculaService->ObtenerPorId($request->matricula_id);
        $matriculaVM->estado = EstadoMatricula::ALetras($matriculaVM->estado);
        $matriculaVM->alumno = $this->_alumnoService->BuscarPorId($matriculaVM->alumno_id);
        $matriculaVM->cronogramas = $this->_cronogramaService->ObtenerCronogramasPorMatriculaId($matriculaVM->id);
        $matriculaVM->vacante = $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
        return response()->json($matriculaVM);
    }
    public function ActualizarMonto(Request $request)
    {
        return $this->_cronogramaService->Actualizar((object)$request->cronograma);
    }
}
