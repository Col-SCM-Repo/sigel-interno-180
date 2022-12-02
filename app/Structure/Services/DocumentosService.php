<?php
namespace App\Structure\Services;

use App\Mappers\DocumentoMapper;
use App\Structure\Repository\DocumentoRepository;

class DocumentosService
{
    protected $_documentoMapper;
    protected $_documentoRepository;

    public function __construct()
    {
       $this->_documentoMapper = new DocumentoMapper();
       $this->_documentoRepository = new DocumentoRepository();
    }

    public function BuscarDocumentoPorId( $documento_id ){
        return $this->_documentoMapper->ModelToViewModel( $this->_documentoRepository->ObtenerDocumentoPorId($documento_id) );
    }

    public function BuscarPorModuloSistemaId( $modulo_sistema_id = 0 ){
        $_listaDocumentos_M = $modulo_sistema_id == 0 ? $this->_documentoRepository->ObtenerTodosDocumentos() : $this->_documentoRepository->BuscarPorModuloSistemaId($modulo_sistema_id);
        return $this->_documentoMapper->ListModelToViewModel( $_listaDocumentos_M );
    }

    public function ViewModel (){
        return $this->_documentoMapper->ViewModel();
    }

    public function ObtenerTodosDocumentos () {
        return $this->_documentoMapper->ListModelToViewModel( $this->_documentoRepository->ObtenerTodosDocumentos() );
    }

    public function Guardar( $_documentoVM ){
        $_documentoM = $this->_documentoMapper->ViewModelToModel($_documentoVM);
        if( $_documentoVM->id != 0 )
            return $this->_documentoRepository->Actualizar($_documentoM);
        return $this->_documentoRepository->Crear($_documentoM);
    }

    public function eliminar ( $documento_id ){
        return $this->_documentoRepository->Eliminar($documento_id);
    }
}
