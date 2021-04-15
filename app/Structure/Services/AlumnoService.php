<?php
namespace App\Structure\Services;

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
        $listaAlumnmos = $this->_alumnoRepository->BuscarPorNombresApellidosDNI($texto);
        $listAlumnosViewModel = $this->_alumnoMapper->ListModelToViewModel($listaAlumnmos);
        return $listAlumnosViewModel;
    }
}
