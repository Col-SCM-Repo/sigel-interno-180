<?php
namespace App\Structure\Services;

use App\Mappers\OcupacionMapper;
use App\Structure\Repository\OcupacionRepository;

class OcupacionService
{
    protected $_ocupacionMapper;
    protected $_ocupacionRepository;
    public function __construct()
    {
       $this->_ocupacionMapper = new OcupacionMapper();
       $this->_ocupacionRepository = new OcupacionRepository();
    }
    public function ObtenerOcupaciones()
    {
        return $this->_ocupacionMapper->ListModelToViewModel($this->_ocupacionRepository->ObtenerTodos());
    }
    public function CrearViewModel()
    {
        return $this->_ocupacionMapper->ViewModel();
    }
    public function Guardar($ocupacionVM)
    {
        return $this->_ocupacionRepository->Crear($this->_ocupacionMapper->ViewModelToModel($ocupacionVM));
    }
}
