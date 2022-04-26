<?php
namespace App\Structure\Services\ModuloNotas;

use App\Mappers\ModuloNotas\NotaMapper;
use App\Structure\Repository\NotaRepository;

class NotaService
{
    protected $_notaMapper;
    protected $_notaRepository;

    public function __construct()
    {
       $this->_notaMapper = new NotaMapper();
       $this->_notaRepository = new NotaRepository();
    }
    public function ObtenerCursosPorMatriculaTrimestre($matriculaId, $trimeste)
    {
        $listaNotasM = $this->_notaRepository->ObtenerPorMatriculaTrimestre($matriculaId, $trimeste);
        dd($listaNotasM);

        return;
    }
}
