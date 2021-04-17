<?php
namespace App\Structure\Services;

use App\Mappers\NivelMapper;
use App\Structure\Repository\NivelRepository;

class NivelService
{
    protected $_nivelMapper;
    protected $_nivelRepository;
    public function __construct()
    {
       $this->_nivelMapper = new NivelMapper();
       $this->_nivelRepository = new NivelRepository();
    }
    public function BuscarPorId($nivel_id)
    {
        $_nivelVM = $this->_nivelMapper->ModelToViewModel($this->_nivelRepository->BuscarPorId($nivel_id));
        return $_nivelVM;
    }

}
