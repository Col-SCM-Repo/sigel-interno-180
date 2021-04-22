<?php
namespace App\Structure\Services;

use App\Mappers\ApoderadoMapper;
use App\Structure\Repository\ParentescoRepositoy;

class ParentescoService
{
    protected $_apoderadoMapper;
    protected $_parentescoRepository;
    public function __construct()
    {
       $this->_apoderadoMapper = new ApoderadoMapper();
       $this->_parentescoRepository = new ParentescoRepositoy();
    }
    public function BuscarPorAlumnoId($alumno_id)
    {
        $_listApoderadosVM = $this->_apoderadoMapper->ListModelToViewModel($this->_parentescoRepository->BuscarPorAlumnoId($alumno_id));
        return $_listApoderadosVM;
    }

}
