<?php
namespace App\Structure\Services\Concreties;

use App\Mappers\AlumnoMapper;
use App\Structure\Repository\Concreties\AlumnoRepository;
use App\Structure\Services\Abstracts\IAlumnoService;

class AlumnoService  implements  IAlumnoService
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
