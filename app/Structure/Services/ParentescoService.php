<?php
namespace App\Structure\Services;

use App\Mappers\ApoderadoMapper;
use App\Structure\Repository\ParentescoRepositoy;

class ParentescoService
{
    protected $_apoderadoMapper;
    protected $_parentescoRepository;
    protected $_tipoParentescoService;
    public function __construct()
    {
       $this->_apoderadoMapper = new ApoderadoMapper();
       $this->_parentescoRepository = new ParentescoRepositoy();
       $this->_tipoParentescoService = new TipoParentescoService();
    }
    public function BuscarPorAlumnoId($alumno_id)
    {
        $_listApoderadosVM = $this->_apoderadoMapper->ListModelToViewModel($this->_parentescoRepository->BuscarPorAlumnoId($alumno_id));
        foreach ($_listApoderadosVM as $apoderado) {
            $apoderado->tipo_parentesco= $this->_tipoParentescoService->BuscarPorId($apoderado->tipo_parentesco_id);
        }
        return $_listApoderadosVM;
    }
    public function BuscarPorID($parentesco_id)
    {
        return $this->_apoderadoMapper->ParentescoModelToViewModel($this->_parentescoRepository->BuscarPorID($parentesco_id));
    }
}
