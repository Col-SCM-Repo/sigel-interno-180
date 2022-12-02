<?php
namespace App\Structure\Services;

use App\Mappers\ModuloSistemaMapper;
use App\Structure\Repository\ModuloSistemaRepository;

class ModuloSistemaService
{
    protected $_moduloSistemaMapper;
    protected $_moduloSistemaRepository;

    public function __construct()
    {
        $this->_moduloSistemaMapper = new ModuloSistemaMapper();
        $this->_moduloSistemaRepository = new ModuloSistemaRepository();
    }

    public function ObtenerTodosModulos () {
        return $this->_moduloSistemaMapper->ListModelToViewModel( $this->_moduloSistemaRepository->ObtenerTodosModulos() );
    }

    public function BuscarModuloPorId( $modulo_sistema_id ){
        return $this->_moduloSistemaMapper->ModelToViewModel( $this->_moduloSistemaRepository->BuscarModuloPorId($modulo_sistema_id) );
    }

    public function BuscarModuloPorNombre( $modulo_sistema_nombre ){
        return $this->_moduloSistemaMapper->ModelToViewModel( $this->_moduloSistemaRepository->BuscarModuloPorNombre($modulo_sistema_nombre) );
    }

    public function Guardar ( $_moduloSistema_VM ){
        $_moduloSistema_M = $this->_moduloSistemaMapper->ViewModelToModel( $_moduloSistema_VM );
        if($_moduloSistema_VM->id != 0)
            return $this->_moduloSistemaRepository->Actualizar($_moduloSistema_M);
        return $this->_moduloSistemaRepository->Crear($_moduloSistema_M);
    }

    public function Eliminar ( $modulo_sistema_id ) {
        return $this->_moduloSistemaRepository->Eliminar($modulo_sistema_id);
    }
}
