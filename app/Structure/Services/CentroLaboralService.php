<?php
namespace App\Structure\Services;

use App\Mappers\CentroLaboralMapper;
use App\Structure\Repository\CentroLaboralRepository;

class CentroLaboralService
{
    protected $_centroLaboralMapper;
    protected $_centroLaboralRepository;
    public function __construct()
    {
       $this->_centroLaboralMapper = new CentroLaboralMapper();
       $this->_centroLaboralRepository = new CentroLaboralRepository();
    }
    public function ObtenerCentrosLaboral()
    {
        return $this->_centroLaboralMapper->ListModelToViewModel($this->_centroLaboralRepository->ObtenerTodos());
    }
    public function CrearViewModel()
    {
        return $this->_centroLaboralMapper->ViewModel();
    }
    public function Guardar($distritoVM)
    {
        return $this->_centroLaboralRepository->Crear($this->_centroLaboralMapper->ViewModelToModel($distritoVM));
    }
}
