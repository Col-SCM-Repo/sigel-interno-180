<?php
namespace App\Structure\Services;

use App\Mappers\DistritoMapper;
use App\Structure\Repository\DistritoRepository;

class DistritoService
{
    protected $_distritoMapper;
    protected $_distritoRepository;
    public function __construct()
    {
       $this->_distritoMapper = new DistritoMapper();
       $this->_distritoRepository = new DistritoRepository();
    }
    public function ObtenerDistritos()
    {
        return $this->_distritoMapper->ListModelToViewModel($this->_distritoRepository->ObtenerTodos());
    }
    public function CrearViewModel()
    {
        return $this->_distritoMapper->ViewModel();
    }
    public function Guardar($distritoVM)
    {
        return $this->_distritoRepository->Crear($this->_distritoMapper->ViewModelToModel($distritoVM));
    }
}
