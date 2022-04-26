<?php
namespace App\Structure\Services;

use App\Mappers\VacanteMapper;
use App\Structure\Repository\VacanteRepository;

class VacanteService
{
    protected $_vacanteMapper;
    protected $_vacanteRepository;
    protected $_anioService;
    protected $_nivelService;
    protected $_gradoService;
    protected $_seccionService;
    public function __construct()
    {
       $this->_vacanteMapper = new VacanteMapper();
       $this->_vacanteRepository = new VacanteRepository();
       $this->_anioService = new AnioAcademicoService();
       $this->_nivelService = new NivelService();
       $this->_gradoService = new GradoService();
       $this->_seccionService = new SeccionService();
    }
    public function BuscarPorId($vacante_id)
    {
        $_vacanteVM = $this->_vacanteMapper->ModelToViewModel($this->_vacanteRepository->BuscarPorId($vacante_id));
        $_vacanteVM->anio = $this->_anioService->BuscarPorId($_vacanteVM->anio_id) ;
        $_vacanteVM->grado = $this->_gradoService->BuscarPorId($_vacanteVM->grado_id) ;
        $_vacanteVM->seccion = $this->_seccionService->BuscarPorId($_vacanteVM->seccion_id) ;
        $_vacanteVM->nivel = $this->_nivelService->BuscarPorId($_vacanteVM->nivel_id) ;
        return $_vacanteVM;
    }
    public function ObtenerPorAnio($anio_id)
    {
        return $this->_vacanteMapper->ListModelToViewModel($this->_vacanteRepository->BuscarPorAnioId($anio_id));
    }
    public function ObtenerPorAnioNivelGrado($anio_id,$nivel_id,$grado_id)
    {
        return $this->_vacanteMapper->ListModelToViewModel($this->_vacanteRepository->BuscarPorAnioNivelGrado($anio_id,$nivel_id,$grado_id));
    }
    public function ObtenerAulasPorAnioNivel($anio_id,$nivel_id)
    {
        return $this->_vacanteMapper->ListModelToViewModel($this->_vacanteRepository->BuscarAulasPorAnioNivel($anio_id,$nivel_id));
    }
    public function ObtenerViewModel()
    {
        return $this->_vacanteMapper->ViewModel();
    }
    public function Guardar($_vacanteVM)
    {
        $_vacanteModel = $this->_vacanteMapper->ViewModelToModel($_vacanteVM);
        if ($_vacanteVM->id!=0) {
            return $this->_vacanteRepository->Actualizar($_vacanteModel);
        }else{
            return $this->_vacanteRepository->Crear($_vacanteModel);
        }
    }
}
