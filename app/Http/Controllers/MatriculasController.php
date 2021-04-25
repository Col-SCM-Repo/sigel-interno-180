<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\AlumnoService;
use App\Structure\Services\InstitucionEducativaService;
use App\Structure\Services\MatriculaService;
use App\Structure\Services\ParentescoService;
use Illuminate\Http\Request;

class MatriculasController extends Controller
{
    protected $ordenarArray;
    protected $_matriculaService;
    protected $_alumnoService;
    protected $_parentescoService;
    protected $_institucionEducativaService;
    public function __construct(OrdenarArray $ordenarArray,
                                MatriculaService $_matriculaService,
                                AlumnoService $_alumnoService,
                                ParentescoService $_parentescoService,
                                InstitucionEducativaService $_institucionEducativaService)
    {
       $this->ordenarArray = $ordenarArray;
       $this->_matriculaService = $_matriculaService;
       $this->_alumnoService = $_alumnoService;
       $this->_parentescoService = $_parentescoService;
       $this->_institucionEducativaService = $_institucionEducativaService;
    }
    public function ObtenerMatriculasPorAlumno(Request $request)
    {
        $_listMatriculas = $this->_matriculaService->ObtenerMatriculasPorAlumno($request->alumno_id);
        return response()->json($_listMatriculas);
    }

    public function NuevaVista($alumno_id,$matricula_id)
    {
       return view('matriculas.nueva')->with('alumno_id', $alumno_id)->with('matricula_id', $matricula_id);
    }
    public function ObtenerModelos(Request $request)
    {
        if ($request->matricula_id ==0) {
            $matricula = $this->_matriculaService->CrearViewModel();
        }else{
            $matricula = $this->_matriculaService->ObtenerPorId($request->matricula_id);
        }
        if ($request->alumno_id ==0) {
            $alumno = $this->_alumnoService->CrearViewModel();
        }else{
            $alumno = $this->_alumnoService->BuscarPorId($request->alumno_id);
            $alumno->apoderados = $this->_parentescoService->BuscarPorAlumnoId($alumno->id);
        }
        $data = [
            'alumno'=>$alumno,
            'matricula'=>$matricula,
            'instituciones_educativas'=> $this->_institucionEducativaService->ObtenerTodas()
        ];
        return response()->json($data);
    }

    public function Guardar(Request $request)
    {
        return $this->_matriculaService->Guardar((object)$request->matricula);
    }
}
