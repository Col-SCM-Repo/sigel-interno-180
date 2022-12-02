<?php
namespace App\Mappers;

use App\Documento;
use App\ViewModel\DocumentoViewModel;

class DocumentoMapper
{
    public function ModelToViewModel( $_documento)
    {
        if(!$_documento) return null;
        $_documentoVM = new DocumentoViewModel();
        $_documentoVM->id =$_documento->MP_DOCUMENTOS_ID;
        $_documentoVM->directorio =$_documento->MP_DIRECTORIO_ARCHIVO;
        $_documentoVM->nombre_archivo =$_documento->MP_NOMBRE_ARCHIVO;
        $_documentoVM->usuario_id =$_documento->USU_ID;
        $_documentoVM->usuario =$_documento->usuario->apellidos().', '.$_documento->usuario->nombres();
        $_documentoVM->modulo_sistema_id =$_documento->MP_MODULOS_SISTEMA_ID;
        $_documentoVM->modulo_sistema =$_documento->moduloSistema->nombre();
        $_documentoVM->tipo_documento =$_documento->MP_TIPO_DOCUMENTO;
        return $_documentoVM;
    }
    public function ListModelToViewModel($_documentosM)
    {
        $_listDocumentosVM = [];
        foreach ($_documentosM as $documentoM) {
            array_push($_listDocumentosVM, self::ModelToViewModel($documentoM));
        }
        return $_listDocumentosVM;
    }
    public function ViewModel()
    {
        return new DocumentoViewModel();
    }
    public function ViewModelToModel($_documentoVM)
    {
        if(!$_documentoVM) return null;
        $_documentoModel = new Documento();
        $_documentoModel->MP_DOCUMENTOS_ID =$_documentoVM->id != 0? $_documentoVM->id : null  ;
        $_documentoModel->MP_DIRECTORIO_ARCHIVO =$_documentoVM->directorio ;
        $_documentoModel->MP_NOMBRE_ARCHIVO =$_documentoVM->nombre_archivo ;
        $_documentoModel->USU_ID =$_documentoVM->usuario_id ;
        $_documentoModel->MP_MODULOS_SISTEMA_ID =$_documentoVM->modulo_sistema_id ;
        $_documentoModel->MP_TIPO_DOCUMENTO = $_documentoVM->tipo_documento;
        return $_documentoModel;
    }
}
