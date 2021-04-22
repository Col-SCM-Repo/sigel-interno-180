<?php
namespace App\Structure\Services;

use App\Mappers\PaisMapper;
use App\Structure\Repository\PaisRepository;

class PaisService
{
    protected $_paisMapper;
    protected $_paisRepository;
    public function __construct()
    {
       $this->_paisMapper = new PaisMapper();
       $this->_paisRepository = new PaisRepository();
    }
    public function ObtenerPaises()
    {
        return $this->_paisMapper->ListModelToViewModel($this->_paisRepository->ObtenerTodos());
    }

}
