<?php
namespace App\Structure\Services;

use App\Mappers\MatriculaMapper;
use App\Structure\Repository\MatriculaRepository;

class MatriculaService
{
    protected $_matriculaMapper;
    protected $_matriculaRepository;
    protected $_vacanteService;
    public function __construct()
    {
       $this->_matriculaMapper = new MatriculaMapper();
       $this->_matriculaRepository = new MatriculaRepository();
       $this->_vacanteService = new VacanteService();
    }
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        $_listMatriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorAlumno($alumno_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
        }
        return $_listMatriculasVM;
    }

}
