<?php
namespace App\Structure\Repository;

use App\Documento;
use Exception;
use Illuminate\Support\Facades\Auth;

class DocumentoRepository extends Documento
{
    public function ObtenerTodosDocumentos (){
        return self::all();
    }

    public function BuscarPorModuloSistemaId( $modulo_sistema_id ){
        return self::where('MP_MODULOS_SISTEMA_ID', $modulo_sistema_id)->get();
    }

    public function ObtenerDocumentoPorId ( $documento_id ){
        return self::find($documento_id );
    }

    public function Crear ( $_documentoM ){
        $nuevoDocumento = new Documento();
        $nuevoDocumento->MP_DIRECTORIO_ARCHIVO = $_documentoM->MP_DIRECTORIO_ARCHIVO;
        $nuevoDocumento->MP_NOMBRE_ARCHIVO = $_documentoM->MP_NOMBRE_ARCHIVO;
        $nuevoDocumento->USU_ID = Auth::user()->id();
        $nuevoDocumento->MP_MODULOS_SISTEMA_ID = $_documentoM->MP_MODULOS_SISTEMA_ID;
        $nuevoDocumento->MP_TIPO_DOCUMENTO = $_documentoM->MP_TIPO_DOCUMENTO;
        $nuevoDocumento->save();
        return $nuevoDocumento->id();
    }

    public function Actualizar($_documentoM)
    {
        $actualizarDocumento = self::find($_documentoM->id());
        if(!$actualizarDocumento) throw new Exception('Error, no se encontro el documento indicado');

       /*  $actualizarDocumento->MP_DOCUMENTOS_ID = $_documentoM->MP_DOCUMENTOS_ID; */
        $actualizarDocumento->MP_DIRECTORIO_ARCHIVO = $_documentoM->MP_DIRECTORIO_ARCHIVO;
        $actualizarDocumento->MP_NOMBRE_ARCHIVO = $_documentoM->MP_NOMBRE_ARCHIVO;
        $actualizarDocumento->USU_ID = $_documentoM->USU_ID;
        $actualizarDocumento->MP_MODULOS_SISTEMA_ID = $_documentoM->MP_MODULOS_SISTEMA_ID;
        $actualizarDocumento->MP_TIPO_DOCUMENTO = $_documentoM->MP_TIPO_DOCUMENTO;
        $actualizarDocumento->save();
        return $actualizarDocumento->id();
    }

    public function Eliminar ( $documento_id ){
        $documentoM = self::find($documento_id);
        if(!$documentoM) throw new Exception('Error, no se encontró el documento indicado. ');
        $documentoM->delete();
        return true;
    }
}
