<?php
namespace App\Structure\Services;

use App\Mappers\AnioAcademicoMapper;
use App\Structure\Repository\AnioAcademicoRepository;

class AnioAcademicoService
{
    protected $_anioAcademicoMapper;
    protected $_anioAcademicoRepository;
    public function __construct()
    {
       $this->_anioAcademicoMapper = new AnioAcademicoMapper();
       $this->_anioAcademicoRepository = new AnioAcademicoRepository();
    }
    public function ObtenerTodos()
    {
        return $this->_anioAcademicoMapper->ListModelToViewModel($this->_anioAcademicoRepository->ObtenerTodos());
    }
    public function ObtenerAnioVigente()
    {
        return $this->_anioAcademicoMapper->ModelToViewModel($this->_anioAcademicoRepository->ObtenerAnioVigente());
    }
    public function BuscarPorId($anio_id)
    {
        return $this->_anioAcademicoMapper->ModelToViewModel($this->_anioAcademicoRepository->BuscarPorId($anio_id));
    }
}
