<?php
namespace App\Structure\Services;

use App\Mappers\GradoMapper;
use App\Structure\Repository\GradoRepository;

class GradoService
{
    protected $_gradoMapper;
    protected $_gradoRepository;
    public function __construct()
    {
       $this->_gradoMapper = new GradoMapper();
       $this->_gradoRepository = new GradoRepository();
    }
    public function BuscarPorId($vacante_id)
    {
        $_gradoVM = $this->_gradoMapper->ModelToViewModel($this->_gradoRepository->BuscarPorId($vacante_id));
        return $_gradoVM;
    }

}
