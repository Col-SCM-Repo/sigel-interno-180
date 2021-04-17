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

}
