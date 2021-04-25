<?php
namespace App\Structure\Services;

use App\Mappers\InstitucionEducativaMapper;
use App\Mappers\NivelMapper;
use App\Structure\Repository\InstitucionEducativaRepository;
use App\Structure\Repository\NivelRepository;

class InstitucionEducativaService
{
    protected $_institucionEducativaMapper;
    protected $_institucionEducativaRepository;
    public function __construct()
    {
       $this->_institucionEducativaMapper = new InstitucionEducativaMapper();
       $this->_institucionEducativaRepository = new InstitucionEducativaRepository();
    }
    public function ObtenerTodas()
    {
        $_institucionEducativaVM = $this->_institucionEducativaMapper->ListModelToViewModel($this->_institucionEducativaRepository->ObtenerTodas());
        return $_institucionEducativaVM;
    }
}
