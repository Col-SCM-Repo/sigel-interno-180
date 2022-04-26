<?php
namespace App\Structure\Services;

use App\Mappers\TipoInstitucionEducativaMapper;
use App\Structure\Repository\TipoInstitucionEducativaRepository;

class TipoInstitucionEducativaService
{
    protected $_tipoInstitucionEducativaMapper;
    protected $_tipoInstitucionEducativaRepository;
    public function __construct()
    {
       $this->_tipoInstitucionEducativaMapper = new TipoInstitucionEducativaMapper();
       $this->_tipoInstitucionEducativaRepository = new TipoInstitucionEducativaRepository();
    }
    public function ObtenerTiposInstitucionEducativa()
    {
        return $this->_tipoInstitucionEducativaMapper->ListModelToViewModel($this->_tipoInstitucionEducativaRepository->ObtenerTodos());
    }
    public function BuscarPorId($tipo_id)
    {
        return $this->_tipoInstitucionEducativaMapper->ModelToViewModel( $this->_tipoInstitucionEducativaRepository->BuscarPorId($tipo_id));;
    }
}
