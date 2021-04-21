<?php
namespace App\Structure\Services;

use App\Mappers\MatriculaMapper;
use App\Structure\Repository\MatriculaRepository;

class MatriculaService
{
    protected $_matriculaMapper;
    protected $_matriculaRepository;
    protected $_vacanteService;
    protected $_alumnoService;
    public function __construct()
    {
       $this->_matriculaMapper = new MatriculaMapper();
       $this->_matriculaRepository = new MatriculaRepository();
       $this->_vacanteService = new VacanteService();
       $this->_alumnoService = new AlumnoService();
    }
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        $_listMatriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorAlumno($alumno_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
        }
        return $_listMatriculasVM;
    }
    public function ObtenerMatriculasPorVacanteId($vacante_id)
    {
        $_listMatriculasVM= $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorVacanteId($vacante_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
            $matriculaVM->alumno =  $this->_alumnoService->BuscarPorId($matriculaVM->alumno_id);
        }
        return $_listMatriculasVM;
    }
}
