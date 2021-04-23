<?php
namespace App\Structure\Services;

use App\Mappers\ApoderadoMapper;
use App\Structure\Repository\ApoderadoRepositoy;
use App\Structure\Repository\ParentescoRepositoy;

class ApoderadoService
{
    protected $_apoderadoMapper;
    protected $_apoderadoRepository;
    protected $_parentescoRepository;
    public function __construct()
    {
       $this->_apoderadoMapper = new ApoderadoMapper();
       $this->_apoderadoRepository = new ApoderadoRepositoy();
       $this->_parentescoRepository = new ParentescoRepositoy();
    }
    public function CrearViewModel()
    {
        return $this->_apoderadoMapper->ViewModel();
    }

    public function GuardarApoderado($apoderadoVM)
    {
        $modelos = $this->_apoderadoMapper->ViewModelToModel($apoderadoVM);
        if ($apoderadoVM->id!=0) {
            $modelos->parentesModel->MP_APO_ID=$this->_apoderadoRepository->Actualizar($modelos->apoderadoModel);
            return $this->_parentescoRepository->Actualizar($modelos->parentesModel);
        }else{
            $modelos->parentesModel->MP_APO_ID=$this->_apoderadoRepository->Crear($modelos->apoderadoModel);
            return $this->_parentescoRepository->Crear($modelos->parentesModel);
        }
    }
}
