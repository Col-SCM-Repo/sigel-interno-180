<?php
namespace App\Structure\Services;

use App\Mappers\CarnetMapper;
use App\Mappers\LocalMapper;
use App\Structure\Repository\CarnetRepository;
use App\Structure\Repository\LocalRepository;

class CarnetService
{
    protected $_carnetMapper;
    protected $_carnetRepository;
    protected $_anioService;
    protected $_nivelService;
    protected $_localService;
    public function __construct()
    {
       $this->_carnetMapper = new CarnetMapper();
       $this->_carnetRepository = new CarnetRepository();
       $this->_anioService = new AnioAcademicoService();
       $this->_nivelService = new NivelService();
       $this->_localService = new LocalService();
    }
    public function BuscarPorId($carnet_id)
    {
        return $this->_carnetMapper->ModelToViewModel($this->_carnetRepository->BuscarPorId($carnet_id));
    }
    public function ObtenerCarnetsPorAnio($anio_id)
    {
        $_listaCarnetsVM = $this->_carnetMapper->ListModelToViewModel($this->_carnetRepository->ObtenerPorAnio($anio_id));
        foreach ($_listaCarnetsVM as $_carnetVM ) {
            $_carnetVM->anio = $this->_anioService->BuscarPorId($_carnetVM->anio_id);
            $_carnetVM->local = $this->_localService->BuscarPorId($_carnetVM->local_id);
            $_carnetVM->nivel = $this->_nivelService->BuscarPorId($_carnetVM->nivel_id);
        }
        return $_listaCarnetsVM;
    }
    public function ObtenerModelo()
    {
        return $this->_carnetMapper->ViewModel();
    }
    public function guardar($_carnetVM)
    {
        $_carnetModel = $this->_carnetMapper->ViewModelToModel($_carnetVM);
        if ($_carnetVM->id!=0) {
            return $this->_carnetRepository->Actualizar($_carnetModel);
        }else{
            return $this->_carnetRepository->Crear($_carnetModel);
        }
    }
    public function GuardarImagen($carnet_id, $imagen )
    {
        $_carnetM = $this->_carnetRepository->BuscarPorId($carnet_id);
        //Save image
        $fileExtencion = pathinfo($imagen->getClientOriginalName())['extension'];
        $fileName = $_carnetM->id .'.'. $fileExtencion;
        $folder = 'images/carnets';
        $_carnetM->path = $imagen->storeAs($folder,$fileName,'publicFile');
        $_carnetM->save();
        return $_carnetM->id;
    }
}
