<?php
namespace App\Structure\Services;

use App\Mappers\SeccionMapper;
use App\Structure\Repository\SeccionRepository;

class SeccionService
{
    protected $_seccionMapper;
    protected $_seccionRepository;
    public function __construct()
    {
       $this->_seccionMapper = new SeccionMapper();
       $this->_seccionRepository = new SeccionRepository();
    }
    public function BuscarPorId($vacante_id)
    {
        $_seccionVM = $this->_seccionMapper->ModelToViewModel($this->_seccionRepository->BuscarPorId($vacante_id));
        return $_seccionVM;
    }

}
