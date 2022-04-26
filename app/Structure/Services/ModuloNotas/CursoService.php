<?php
namespace App\Structure\Services\ModuloNotas;

use App\Mappers\ModuloNotas\AlumnoMapper;
use App\Mappers\ModuloNotas\CursoMapper;
use App\Mappers\ModuloNotas\NotaMapper;
use App\Structure\Repository\MatriculaRepository;
use App\Structure\Repository\NotaRepository;

class CursoService
{
    protected $_notaMapper;
    protected $_cursoMapper;
    protected $_alumnoMapper;
    protected $_notaRepository;
    protected $_matriculaRepository;

    public function __construct()
    {
       $this->_notaMapper = new NotaMapper();
       $this->_cursoMapper = new CursoMapper();
       $this->_alumnoMapper = new AlumnoMapper();
       $this->_notaRepository = new NotaRepository();
       $this->_matriculaRepository = new MatriculaRepository();
    }

    public function ObtenerCursosPorMatriculaTrimestre($matricula_id, $trimeste)
    {
        $_matriculaModel = $this->_matriculaRepository->ObtenerPorId($matricula_id);
        $_alumnoVM = $this->_alumnoMapper->ModelToViewModel($_matriculaModel);
        foreach ($_matriculaModel->Notas->where('periodo_id', $trimeste) as $_notaModel) {
            $_cursoVM = $this->_cursoMapper->ModelToViewModel($_notaModel->ResponsableVacante->Responsable->Curso);
            $_cursoVM->notas = $this->_notaMapper->ModelToViewModel($_notaModel);
            array_push($_alumnoVM->cursos,$_cursoVM);
        }
        return $_alumnoVM;
    }
}
