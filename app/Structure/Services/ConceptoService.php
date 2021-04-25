<?php
namespace App\Structure\Services;

use App\Mappers\ConceptoMapper;

class ConceptoService
{
    protected $_conceptoMapper;
    public function __construct()
    {
       $this->_conceptoMapper = new ConceptoMapper();
    }


}
