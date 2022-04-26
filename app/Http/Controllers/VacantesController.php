<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\AnioAcademicoService;
use App\Structure\Services\VacanteService;
use Illuminate\Http\Request;

class VacantesController extends Controller
{
    protected $ordenarArray;
    protected $_vacanteService;
    protected $_anioService;
    public function __construct(OrdenarArray $ordenarArray,
                                VacanteService $_vacanteService,
                                AnioAcademicoService $_anioService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_vacanteService = $_vacanteService;
        $this->_anioService = $_anioService;
    }
    public function PorAnio()
    {
        return view('modulos.pagosMatriculas.vacantes.por_anio');
    }
    public function ObtenerAulasPorAnio(Request $request)
    {
        return response()->json($this->_vacanteService->ObtenerPorAnio($request->anio_id));
    }
    public function ObtenerPorNivelGradoAnio(Request $request)
    {
        $_anio = $this->_anioService->ObtenerAnioVigente();
        return response()->json($this->_vacanteService->ObtenerPorAnioNivelGrado($_anio->id,$request->nivel_id,$request->grado_id));
    }

    public function VistaReportePorAnioNivel()
    {
        return view('modulos.pagosMatriculas.vacantes.total_alumno_anio_nivel');
    }
    public function ObtenerSeccionesPorAnionivel(Request $request)
    {
        return $this->_vacanteService->ObtenerAulasPorAnioNivel($request->anio_id,$request->nivel_id);
    }
    public function ObtenerViewModel()
    {
        return response()->json($this->_vacanteService->ObtenerViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_vacanteService->Guardar((object) $request->vacante));
    }
}
