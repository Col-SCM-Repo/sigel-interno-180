<?php
namespace App\ViewModel;

use App\Enums\TipoDocumentoEnum;

class DocumentoViewModel
{
    public $id =0;
    public $directorio ='';
    public $nombre_archivo ='';
    public $usuario_id = 0;
    public $modulo_sistema_id = '';
    public $tipo_documento = TipoDocumentoEnum::NoModificable;
}
