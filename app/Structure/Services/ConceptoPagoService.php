<?php
namespace App\Structure\Services;

use App\Mappers\ConceptoMapper;
use App\Structure\Repository\ConceptoPagoRepository;

class ConceptoPagoService
{
    protected $_conceptoMapper;
    protected $_anioService;
    protected $_nivelService;
    protected $_localService;
    protected $_conceptoPagoRepository;
    public function __construct()
    {
       $this->_conceptoMapper = new ConceptoMapper();
       $this->_anioService = new AnioAcademicoService();
       $this->_nivelService = new NivelService();
       $this->_localService = new LocalService();
       $this->_conceptoPagoRepository = new ConceptoPagoRepository();
    }
    public function ObtenerPensionesAnioActualYNivel($nivelId)
    {
        $anioActual = $this->_anioService->ObtenerAnioVigente();
        return $this->_conceptoMapper->ListConceptoPagoModelToConceptoViewModel($this->_conceptoPagoRepository->BuscarPorAnioYNivel($anioActual->id, $nivelId));
    }
    public function ObtenerPorId($conceptoPagoId)
    {
        $_conceptoPagoM = $this->_conceptoPagoRepository->buscarPorId($conceptoPagoId);
        return $this->_conceptoMapper->ConceptoPagoModelToViewModel($_conceptoPagoM, $_conceptoPagoM->Concepto);
    }
    public function ObtenerConceptosPorAnio($anio_id)
    {
        return $this->_conceptoMapper->ListConceptoPagoModelToConceptoViewModel($this->_conceptoPagoRepository->BuscarOtrosConceptosPorAnio($anio_id));
    }
    public function ObtenerTodosConceptosPorAnio($anio_id)
    {
        $_listaConceptosVM = $this->_conceptoMapper->ListConceptoPagoModelToConceptoViewModel($this->_conceptoPagoRepository->BuscarConceptosPorAnio($anio_id));
        foreach ($_listaConceptosVM as $_conceptoVM) {
            $_conceptoVM->nivel = isset($_conceptoVM->nivel_id)?$this->_nivelService->BuscarPorId($_conceptoVM->nivel_id):'-';
            $_conceptoVM->local = isset($_conceptoVM->local_id)? $this->_localService->BuscarPorId($_conceptoVM->local_id):'-';
        }
        return $_listaConceptosVM;
    }

    public function guardar($_conceptoVM)
    {
        $_conceptoPagoModel = $this->_conceptoMapper->ViewModelToModelConceptoPago($_conceptoVM);
        if ($_conceptoVM->concepto_pago_id!=0) {
            return $this->_conceptoPagoRepository->Actualizar($_conceptoPagoModel);
        }else{
            return $this->_conceptoPagoRepository->Crear($_conceptoPagoModel);
        }
    }
}
