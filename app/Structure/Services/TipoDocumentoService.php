<?php
namespace App\Structure\Services;

use App\Mappers\PaisMapper;
use App\Mappers\TipoDocumentoMapper;
use App\Structure\Repository\PaisRepository;
use App\Structure\Repository\TipoDocumentoRepository;

class TipoDocumentoService
{
    protected $_tipoDocumentoMapper;
    protected $_tipoDocumentoRepository;
    public function __construct()
    {
       $this->_tipoDocumentoMapper = new TipoDocumentoMapper();
       $this->_tipoDocumentoRepository = new TipoDocumentoRepository();
    }
    public function ObtenerTiposDocumento()
    {
        return $this->_tipoDocumentoMapper->ListModelToViewModel($this->_tipoDocumentoRepository->ObtenerTodos());
    }

}
