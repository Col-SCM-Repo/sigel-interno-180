<?php
namespace App\Structure\Services;

use App\Mappers\GradoInstruccionMapper;
use App\Structure\Repository\GradoInstruccionRepository;

class GradoInstruccionService
{
    protected $_gradoInstruccionMapper;
    protected $_gradoInstruccionRepository;
    public function __construct()
    {
       $this->_gradoInstruccionMapper = new GradoInstruccionMapper();
       $this->_gradoInstruccionRepository = new GradoInstruccionRepository();
    }
    public function ObtenerGradosInstruccion()
    {
        return $this->_gradoInstruccionMapper->ListModelToViewModel($this->_gradoInstruccionRepository->ObtenerTodos());
    }
}
