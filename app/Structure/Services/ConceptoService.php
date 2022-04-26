<?php
namespace App\Structure\Services;

use App\Mappers\ConceptoMapper;
use App\Structure\Repository\ConceptoRepository;

class ConceptoService
{
    protected $_conceptoMapper;
    protected $_conceptoRepository;
    public function __construct()
    {
       $this->_conceptoMapper = new ConceptoMapper();
       $this->_conceptoRepository = new ConceptoRepository();
    }
    public function ObtenerModelo()
    {
        return $this->_conceptoMapper->ViewModel();
    }
    public function ObtenerConceptos()
    {
        return $this->_conceptoMapper->ListConceptoModelToConceptoViewModel($this->_conceptoRepository->ObtenerTodos());
    }
}
