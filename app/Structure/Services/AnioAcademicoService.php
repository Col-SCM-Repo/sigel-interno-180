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
    public function ObtenerViewModel()
    {
        return $this->_anioAcademicoMapper->ViewModel();
    }
    public function Guardar($_anioVM)
    {
        $_anioModel = $this->_anioAcademicoMapper->ViewModelToModel($_anioVM);
        if ($_anioVM->id!=0) {
            return $this->_anioAcademicoRepository->Actualizar($_anioModel);
        }else{
            return $this->_anioAcademicoRepository->Crear($_anioModel);
        }
    }
}
