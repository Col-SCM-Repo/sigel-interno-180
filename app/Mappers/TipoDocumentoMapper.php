<?php
namespace App\Mappers;

use App\TipoDocumento;
use App\ViewModel\TipoDocumentoViewModel;

class TipoDocumentoMapper
{
    public function ModelToViewModel(TipoDocumento $_tipoDocumento)
    {
        $__tipoDocumentoVM = new TipoDocumentoViewModel();
        $__tipoDocumentoVM->id =$_tipoDocumento->MP_TIPDOC_ID;
        $__tipoDocumentoVM->nombre =$_tipoDocumento->MP_TIPDOC_NOMBRE;
        return $__tipoDocumentoVM;
    }
    public function ListModelToViewModel($_tiposDocumento)
    {
        $_listTiposDocumento = [];
        foreach ($_tiposDocumento as $tipos) {
            array_push($_listTiposDocumento, self::ModelToViewModel($tipos));
        }
        return $_listTiposDocumento;
    }
}
