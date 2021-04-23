<?php
namespace App\Structure\Services;

use App\Mappers\PaisMapper;
use App\Mappers\TipoParentescoMapper;
use App\Structure\Repository\PaisRepository;
use App\Structure\Repository\TipoParentescoRepository;

class TipoParentescoService
{
    protected $_tipoParentescoMapper;
    protected $_tipoParentescoRepository;
    public function __construct()
    {
       $this->_tipoParentescoMapper = new TipoParentescoMapper();
       $this->_tipoParentescoRepository = new TipoParentescoRepository();
    }
    public function ObtenerTiposParentesco()
    {
        return $this->_tipoParentescoMapper->ListModelToViewModel($this->_tipoParentescoRepository->ObtenerTodos());
    }
    public function BuscarPorId($tipo_parentesco_id)
    {
        return $this->_tipoParentescoMapper->ModelToViewModel( $this->_tipoParentescoRepository->BuscarPorId($tipo_parentesco_id));;
    }
}
