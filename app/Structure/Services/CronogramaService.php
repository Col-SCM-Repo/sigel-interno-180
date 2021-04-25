<?php
namespace App\Structure\Services;

use App\Mappers\CronogramaMapper;
use App\Structure\Repository\CronogramaRepository;

class CronogramaService
{
    protected $_cronogramaMapper;
    protected $_cronogramaRepository;
    public function __construct()
    {
       $this->_cronogramaMapper = new CronogramaMapper();
       $this->_cronogramaRepository = new CronogramaRepository();
    }
    public function CrearCronograma($matricula_id)
    {
        $_cronogramaVM = $this->_cronogramaMapper->ListModelToViewModel($this->_cronogramaRepository->BuscarPorMatriculaId($matricula_id));
        return $_cronogramaVM;
    }
    public function Actualizar($cronogramaVM)
    {
        return $this->_cronogramaRepository->Actualizar($this->_cronogramaMapper->ViewModelToModel($cronogramaVM));
    }
    public function Crear($cronogramaVM)
    {
        return $this->_cronogramaRepository->Crear($this->_cronogramaMapper->ViewModelToModel($cronogramaVM));
    }
    public function CrearViewModel()
    {
        return $this->_cronogramaMapper->ViewModel();
    }
}
