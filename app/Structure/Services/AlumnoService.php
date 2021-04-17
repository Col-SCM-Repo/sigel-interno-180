<?php
namespace App\Structure\Services;

use App\Enums\JsonEnums;
use App\Mappers\AlumnoMapper;
use App\Structure\Repository\AlumnoRepository;

class AlumnoService
{
    private $_alumnoRepository ;
    private $_alumnoMapper ;
    public function __construct()
    {
        $this->_alumnoRepository =  new AlumnoRepository();
        $this->_alumnoMapper =  new AlumnoMapper();
    }
    public function BuscarPorNombresApellidosDNI($texto)
    {
        return $this->_alumnoMapper->ListModelToViewModel($this->_alumnoRepository->BuscarPorNombresApellidosDNI($texto));;
    }
    public function BuscarPorDNI($dni)
    {
        $_alumnoModel = $this->_alumnoRepository->BuscarPorDNI($dni);
        if(isset($_alumnoModel)){
            return $this->_alumnoMapper->ModelToViewModel($_alumnoModel);
        }else{
            return JsonEnums::NoEncontrado;
        }
    }
}
