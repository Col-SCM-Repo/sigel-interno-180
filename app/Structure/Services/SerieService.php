<?php
namespace App\Structure\Services;

use App\Mappers\SerieMapper;
use App\Structure\Repository\SerieRepository;

class SerieService
{
    protected $_serieMapper;
    protected $_serieRepository;
    public function __construct()
    {
       $this->_serieMapper = new SerieMapper();
       $this->_serieRepository = new SerieRepository();
    }
    public function BuscarPorUsuario($_usuarioId)
    {
        $_serieModel = $this->_serieRepository->BuscarPorUsuario($_usuarioId);
        if(isset($_serieModel))
            return $this->_serieMapper->ModelToViewModel($_serieModel);
        else
            return null;
    }
    public function ObtenerViewModel()
    {
        return $this->_serieMapper->ViewModel();
    }
    public function Guardar($usuarioVM)
    {
        $_serieModel = $this->_serieMapper->ViewModelToModel($usuarioVM);
        if ($usuarioVM->id!=0) {
            return $this->_serieRepository->Actualizar($_serieModel);
        }else{
            return $this->_serieRepository->Crear($_serieModel);
        }
    }
}
