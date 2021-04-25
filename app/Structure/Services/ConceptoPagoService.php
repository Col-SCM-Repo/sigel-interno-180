<?php
namespace App\Structure\Services;

use App\Mappers\ConceptoMapper;
use App\Structure\Repository\ConceptoPagoRepository;

class ConceptoPagoService
{
    protected $_conceptoMapper;
    protected $_anioService;
    protected $_conceptoPagoRepository;
    public function __construct()
    {
       $this->_conceptoMapper = new ConceptoMapper();
       $this->_anioService = new AnioAcademicoService();
       $this->_conceptoPagoRepository = new ConceptoPagoRepository();
    }
    public function ObtenerPensionesAnioActualYNivel($nivel_id)
    {
        $anioActual = $this->_anioService->ObtenerAnioVigente();
        return $this->_conceptoMapper->ListConceptoPagoModelToConceptoViewModel($this->_conceptoPagoRepository->BuscarPorAnioYNivel($anioActual->id, $nivel_id));
    }
}
