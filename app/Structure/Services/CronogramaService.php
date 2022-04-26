<?php
namespace App\Structure\Services;

use App\Mappers\CronogramaMapper;
use App\Structure\Repository\CronogramaRepository;

class CronogramaService
{
    protected $_cronogramaMapper;
    protected $_cronogramaRepository;
    protected $_conceptoPagoService;
    protected $_pagoService;
    public function __construct()
    {
       $this->_cronogramaMapper = new CronogramaMapper();
       $this->_cronogramaRepository = new CronogramaRepository();
       $this->_conceptoPagoService = new ConceptoPagoService();
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
    public function ObtenerCronogramasPorMatriculaId($matricula_id)
    {
        $cronogramasVM = $this->_cronogramaMapper->ListModelToViewModel($this->_cronogramaRepository->BuscarPorMatriculaId($matricula_id));
        foreach ($cronogramasVM as $cronogramaVM) {
            $cronogramaVM->concepto = $this->_conceptoPagoService->ObtenerPorId($cronogramaVM->concepto_pago_id);
        }
        return $cronogramasVM;
    }
    public function BuscarPorId($cronograma_id)
    {
        return $this->_cronogramaMapper->ModelToViewModel($this->_cronogramaRepository->BuscarPorId($cronograma_id));
    }
}
